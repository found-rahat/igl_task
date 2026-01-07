<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        $query = Candidate::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $candidates = $query->latest()->paginate(10)->withQueryString();

        return view('candidates.index', compact('candidates'));
    }

    public function create()
    {
        return view('candidates.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidates',
            'phone' => 'required|string|max:20',
            'experience_years' => 'required|integer|min:0',
            'age' => 'required|integer|min:18',
            'previous_experience' => 'required|array',
            'previous_experience.*.institute' => 'required|string',
            'previous_experience.*.position' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Convert previous_experience array to JSON format
        $previousExperience = [];
        if ($request->has('previous_experience')) {
            foreach ($request->previous_experience as $exp) {
                $previousExperience[$exp['institute']] = $exp['position'];
            }
        }

        Candidate::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'experience_years' => $request->experience_years,
            'previous_experience' => $previousExperience,
            'age' => $request->age,
        ]);

        return redirect()->route('candidates.index')->with('success', 'Candidate added successfully.');
    }

    public function show(Candidate $candidate)
    {
        return view('candidates.show', compact('candidate'));
    }

    public function edit(Candidate $candidate)
    {
        return view('candidates.edit', compact('candidate'));
    }

    public function update(Request $request, Candidate $candidate)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidates,email,' . $candidate->id,
            'phone' => 'required|string|max:20',
            'experience_years' => 'required|integer|min:0',
            'age' => 'required|integer|min:18',
            'previous_experience' => 'required|array',
            'previous_experience.*.institute' => 'required|string',
            'previous_experience.*.position' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Convert previous_experience array to JSON format
        $previousExperience = [];
        if ($request->has('previous_experience')) {
            foreach ($request->previous_experience as $exp) {
                $previousExperience[$exp['institute']] = $exp['position'];
            }
        }

        $candidate->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'experience_years' => $request->experience_years,
            'previous_experience' => $previousExperience,
            'age' => $request->age,
        ]);

        return redirect()->route('candidates.index')->with('success', 'Candidate updated successfully.');
    }

    public function destroy(Candidate $candidate)
    {
        $candidate->delete();
        return redirect()->route('candidates.index')->with('success', 'Candidate deleted successfully.');
    }

    public function importForm()
    {
        return view('candidates.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            $file = $request->file('excel_file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $rows = $spreadsheet->getActiveSheet()->toArray();

            // Remove header
            array_shift($rows);

            $processedCount = 0;
            $skippedCount = 0;

            foreach ($rows as $index => $row) {

                /*
                * Column mapping
                * 0 => SL
                * 1 => Image
                * 2 => Profile Info (Name, Age, Phone, Email)
                * 3 => Career Summary (Company : Position)
                * 4 => Experience & Status
                */

                if (empty(trim($row[2] ?? ''))) {
                    $skippedCount++;
                    continue;
                }

                $profileInfo   = trim($row[2]);
                $careerSummary = trim($row[3] ?? '');
                $experienceRaw = trim($row[4] ?? '');

                /* ---------------- BASIC INFO ---------------- */

                preg_match('/Name:\s*([^\n\r]+)/i', $profileInfo, $m);
                $name = $m[1] ?? null;

                preg_match('/Age:\s*(\d+)/i', $profileInfo, $m);
                $age = isset($m[1]) ? (int) $m[1] : null;

                preg_match('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}/i', $profileInfo, $m);
                $email = $m[0] ?? null;

                preg_match('/(\+?\d[\d\s\-]{9,15})/', $profileInfo, $m);
                $phone = isset($m[1]) ? trim(preg_replace('/\s+/', ' ', $m[1])) : null;

                /* ---------------- EXPERIENCE YEARS ---------------- */

                $experience_years = 0;
                if (preg_match('/Total Experience:\s*(\d+)/i', $experienceRaw, $m)) {
                    $experience_years = (int) $m[1];
                }

                /* ---------------- PREVIOUS EXPERIENCE ---------------- */

                $previousExperience = [];
                if (!empty($careerSummary)) {
                    preg_match_all(
                        '/([^:\n]+)\s*:\s*([^(,\n]+)/',
                        $careerSummary,
                        $matches,
                        PREG_SET_ORDER
                    );

                    foreach ($matches as $match) {
                        $company = trim($match[1]);
                        $position = trim($match[2]);

                        if ($company && $position) {
                            $previousExperience[$company] = $position;
                        }
                    }
                }

                /* ---------------- SAVE ---------------- */

                if (!$email || Candidate::where('email', $email)->exists()) {
                    $skippedCount++;
                    continue;
                }

                Candidate::create([
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'age' => $age,
                    'experience_years' => $experience_years,
                    'previous_experience' => $previousExperience,
                ]);

                $processedCount++;
            }

            return redirect()
                ->route('candidates.index')
                ->with('success', "Import successful. Processed: {$processedCount}, Skipped: {$skippedCount}");

        } catch (\Exception $e) {
            \Log::error($e);
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }


    public function allCandidates()
    {
        $candidates = Candidate::all();
        return view('candidates.all', compact('candidates'));
    }

    public function hiredCandidates()
    {
        $candidates = Candidate::where('status', 'hired')->get();
        return view('candidates.hired', compact('candidates'));
    }

    public function rejectedCandidates()
    {
        $candidates = Candidate::where('status', 'rejected')->get();
        return view('candidates.rejected', compact('candidates'));
    }

    public function scheduleInterviewForm()
    {
        $candidates = Candidate::where('status', 'pending')->get();
        return view('candidates.schedule-interview', compact('candidates'));
    }

    public function scheduleInterview(Request $request)
    {
        $request->validate([
            'interview_date' => 'required|date|after:today',
            'candidate_ids' => 'nullable|array',
            'candidate_ids.*' => 'exists:candidates,id',
            'range_start' => 'nullable|integer|min:1',
            'range_end' => 'nullable|integer|min:1|gte:range_start',
        ]);

        $candidateIds = $request->candidate_ids ?: [];

        // Handle range selection if provided
        if ($request->filled(['range_start', 'range_end'])) {
            $rangeStart = $request->range_start;
            $rangeEnd = $request->range_end;

            // Get candidates within the range
            $rangeCandidates = Candidate::where('status', 'pending')
                ->orderBy('id')
                ->offset($rangeStart - 1)
                ->limit($rangeEnd - $rangeStart + 1)
                ->pluck('id')
                ->toArray();

            $candidateIds = array_merge($candidateIds, $rangeCandidates);
        }

        if (empty($candidateIds)) {
            return redirect()->back()->with('error', 'No candidates selected for interview scheduling.');
        }

        Candidate::whereIn('id', $candidateIds)
            ->update([
                'status' => 'interview_scheduled',
                'interview_date' => $request->interview_date
            ]);

        return redirect()->route('candidates.upcoming-interviews')->with('success', 'Interviews scheduled successfully for ' . count($candidateIds) . ' candidate(s).');
    }

    public function upcomingInterviews()
    {
        \Log::info('upcomingInterviews method called');
        try {
            $candidates = Candidate::whereIn('status', ['interview_scheduled', 'second_interview_scheduled'])
                ->orderBy('interview_date', 'asc')
                ->get();
            \Log::info('Candidates retrieved: ' . $candidates->count());
            return view('candidates.upcoming', compact('candidates'));
        } catch (\Exception $e) {
            \Log::error('Error in upcomingInterviews: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            abort(500, 'Internal server error');
        }
    }

    public function secondInterviews()
    {
        \Log::info('secondInterviews method called');
        try {
            $candidates = Candidate::where('status', 'second_interview_scheduled')
                ->orderBy('interview_date', 'asc')
                ->get();
            \Log::info('Second interview candidates retrieved: ' . $candidates->count());
            return view('candidates.second-interviews', compact('candidates'));
        } catch (\Exception $e) {
            \Log::error('Error in secondInterviews: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            abort(500, 'Internal server error');
        }
    }

    public function completedInterviews()
    {
        \Log::info('completedInterviews method called');
        try {
            // Get candidates who have completed interviews OR had interviews in the past
            // Also include candidates with 'passed' status as they are part of the completed interview flow
            // Exclude 'second_interview_scheduled' as these are upcoming second interviews, not completed
            $candidates = Candidate::where(function($query) {
                $query->where('status', 'interview_completed')
                      ->orWhere('status', 'passed')
                      ->orWhere('status', 'failed')
                      ->orWhere(function($subQuery) {
                          $subQuery->where('status', 'interview_scheduled');
                      });
            })
            ->get();

            \Log::info('Completed candidates retrieved: ' . $candidates->count());
            return view('candidates.completed', compact('candidates'));
        } catch (\Exception $e) {
            \Log::error('Error in completedInterviews: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            abort(500, 'Internal server error');
        }
    }

    public function markInterviewStatus(Request $request, $id)
    {
        \Log::info('markInterviewStatus called', ['id' => $id, 'status' => $request->status]);

        $request->validate([
            'status' => 'required|in:pending,hired,rejected,interview_scheduled,interview_completed,passed,failed,second_interview_scheduled'
        ]);

        $candidate = Candidate::findOrFail($id);

        \Log::info('Updating candidate status', ['candidate_id' => $id, 'new_status' => $request->status]);

        $candidate->update([
            'status' => $request->status,
            'interview_date' => now()
        ]);

        \Log::info('Candidate status updated successfully', ['candidate_id' => $id, 'new_status' => $request->status]);

        return redirect()->back()->with('success', 'Candidate status updated successfully.');
    }

    public function bulkScheduleSecondInterview(Request $request)
    {
        $request->validate([
            'candidate_ids' => 'required|string', // Accept as string since it's JSON
            'interview_date' => 'required|date|after:today'
        ]);

        $candidateIds = json_decode($request->candidate_ids, true);

        if (!is_array($candidateIds) || empty($candidateIds)) {
            return redirect()->back()->with('error', 'Invalid candidate selection.');
        }

        // Validate that all IDs exist in the database
        $existingIds = \App\Models\Candidate::whereIn('id', $candidateIds)->pluck('id')->toArray();

        if (count($existingIds) !== count($candidateIds)) {
            return redirect()->back()->with('error', 'Some selected candidates do not exist.');
        }

        // Get the actual candidates to check their current status
        $candidates = \App\Models\Candidate::whereIn('id', $existingIds)->get();

        // Filter to only include candidates with 'passed' or 'interview_completed' status
        $validCandidateIds = $candidates->filter(function($candidate) {
            return in_array($candidate->status, ['passed', 'interview_completed']);
        })->pluck('id')->toArray();

        if (empty($validCandidateIds)) {
            return redirect()->back()->with('error', 'No selected candidates are eligible for second interview scheduling.');
        }

        // Update the selected candidates
        \App\Models\Candidate::whereIn('id', $validCandidateIds)
            ->update([
                'status' => 'second_interview_scheduled',
                'interview_date' => $request->interview_date
            ]);

        return redirect()->route('candidates.second.interviews')->with('success', 'Second interviews scheduled successfully for ' . count($validCandidateIds) . ' candidate(s).');
    }

    public function downloadPhoneNumbers()
    {
        $candidates = Candidate::where('status', 'interview_scheduled')
            ->where('interview_date', '>=', now())
            ->get();

        $phoneNumbers = $candidates->pluck('phone')->filter()->implode("\n");

        return response($phoneNumbers)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename=upcoming_interview_phones.txt');
    }

    public function searchForm()
    {
        return view('candidates.search');
    }

    public function search(Request $request)
    {
        $request->validate([
            'phone' => 'required|string'
        ]);

        $candidate = Candidate::where('phone', $request->phone)->first();

        if (!$candidate) {
            return redirect()->back()->with('error', 'Candidate not found with this phone number.');
        }

        return view('candidates.search-result', compact('candidate'));
    }

    public function scheduleSecondInterviewForm(Candidate $candidate)
    {
        return view('candidates.schedule-second-interview', compact('candidate'));
    }

    public function scheduleSecondInterview(Request $request, Candidate $candidate)
    {
        $request->validate([
            'interview_date' => 'required|date|after:today'
        ]);

        // Update candidate status to indicate second interview scheduled
        $candidate->update([
            'status' => 'second_interview_scheduled',
            'interview_date' => $request->interview_date
        ]);

        return redirect()->route('candidates.upcoming-interviews')->with('success', 'Second interview scheduled successfully for ' . $candidate->name . '.');
    }
}
