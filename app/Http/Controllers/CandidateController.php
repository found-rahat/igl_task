<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CandidateController extends Controller
{
    public function index()
    {
        $candidates = Candidate::all();
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
        \Log::info('Starting Excel import process');

        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        \Log::info('File validation passed, getting file: ' . $request->file('excel_file')->getClientOriginalName());

        $file = $request->file('excel_file');
        \Log::info('File path: ' . $file->getPathname());

        try {
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            \Log::info('Excel file loaded successfully, total rows: ' . count($rows));

            // Skip the header row
            array_shift($rows);

            $processedCount = 0;
            $skippedCount = 0;

            foreach ($rows as $index => $row) {
                \Log::info('Processing row ' . ($index + 1) . ': ' . json_encode($row));

                // Check if we have enough columns in the row
                if (isset($row[2]) && !empty(trim($row[2]))) { // Career Summary column (Column C)
                    \Log::info('Row has valid Career Summary data');

                    // The Career Summary is in index 2
                    $careerSummary = isset($row[2]) ? trim($row[2]) : '';

                // Extract name using regex
                preg_match('/Name:\s*([^\n\r]+)/', $careerSummary, $nameMatches);
                $name = isset($nameMatches[1]) ? trim($nameMatches[1]) : '';

                // Extract age using regex
                preg_match('/Age:\s*([\d.]+)/', $careerSummary, $ageMatches);
                $age = isset($ageMatches[1]) ? (int)$ageMatches[1] : 0;

                // Extract email using regex (improved pattern to handle various formats)
                preg_match('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/', $careerSummary, $emailMatches);
                $email = isset($emailMatches[1]) ? trim($emailMatches[1]) : '';

                // Extract phone using regex (handles various formats like 1 312-555-4567, +1 312-555-4567, etc.)
                preg_match('/(\+?\d{1,3}[\s-]?\d{3}[\s-]?\d{3}[\s-]?\d{4}|[\d\s-]{10,15})/', $careerSummary, $phoneMatches);
                $phone = isset($phoneMatches[1]) ? trim($phoneMatches[1]) : '';

                // Clean up the phone number format
                $phone = preg_replace('/\s+/', ' ', $phone); // Replace multiple spaces with single space
                $phone = trim($phone);

                // If phone starts with a digit but doesn't have a country code, add +1 as default for US numbers
                if (!empty($phone) && preg_match('/^\d/', $phone) && !preg_match('/^\+/', $phone)) {
                    $digitsOnly = preg_replace('/[^0-9]/', '', $phone);
                    if (strlen($digitsOnly) == 10) {
                        $phone = '+1 ' . implode('-', [
                            substr($digitsOnly, 0, 3),
                            substr($digitsOnly, 3, 3),
                            substr($digitsOnly, 6, 4)
                        ]);
                    } elseif (strlen($digitsOnly) == 11 && substr($digitsOnly, 0, 1) == '1') {
                        $phone = '+1 ' . implode('-', [
                            substr($digitsOnly, 1, 3),
                            substr($digitsOnly, 4, 3),
                            substr($digitsOnly, 7, 4)
                        ]);
                    }
                }

                // Extract total experience years from Experience And Application Status column (index 3)
                $experienceSection = isset($row[4]) ? trim($row[4]) : '';

                // Clean up the experience section to normalize whitespace and line breaks
                $experienceSection = preg_replace('/\s+/', ' ', $experienceSection); // Replace all whitespace sequences with single space
                $experienceSection = trim($experienceSection);

                // Extract total experience years (more flexible pattern to handle various formats)
                $experience_years = 0;

                // Debug: Log the actual content being processed
                \Log::info('Processing experience section: ' . $experienceSection);

                // Try multiple patterns to extract experience years
                if (preg_match('/Total Experience:\s*(\d+)\+?\s*Year[s]?/i', $experienceSection, $expMatches)) {
                    $experience_years = (int)$expMatches[1];
                    \Log::info('Matched pattern 1: ' . $expMatches[0] . ' -> ' . $experience_years);
                } elseif (preg_match('/Total Experience:\s*(\d+(?:\.\d+)?)\+?\s*Year[s]?/i', $experienceSection, $expMatches)) {
                    $experience_years = (int)$expMatches[1];
                    \Log::info('Matched pattern 2: ' . $expMatches[0] . ' -> ' . $experience_years);
                } elseif (preg_match('/Total Experience:\s*(\d+)/i', $experienceSection, $expMatches)) {
                    $experience_years = (int)$expMatches[1];
                    \Log::info('Matched pattern 3: ' . $expMatches[0] . ' -> ' . $experience_years);
                } elseif (preg_match('/Experience:\s*(\d+)/i', $experienceSection, $expMatches)) {
                    $experience_years = (int)$expMatches[1];
                    \Log::info('Matched pattern 4: ' . $expMatches[0] . ' -> ' . $experience_years);
                } else {
                    \Log::info('No pattern matched for experience section: ' . $experienceSection);
                }

                // Extract previous experience details from Career Summary (index 2)
                $careerSummaryForExperience = $careerSummary; // This is already index 2

                // Clean up the career summary to normalize whitespace and line breaks
                $careerSummaryForExperience = preg_replace('/\s+/', ' ', $careerSummaryForExperience); // Replace all whitespace sequences with single space
                $careerSummaryForExperience = trim($careerSummaryForExperience);

                // Extract previous experience details from Career Summary
                $previousExperience = [];

                // Look for company and position pairs in the career summary (enhanced pattern to handle special characters)
                $pattern = '/([A-Za-z\s&.`\'\-]+(?:Solutions|Innovations|Technologies|Systems|IT|Lab|Pte\. Ltd|Ltd|LLC|Inc|Corp|Group|Alpha|Edutech|limited|BD|Consultancy|enterprise)[^:]*)\s*:\s*([^(]+)/';
                preg_match_all($pattern, $careerSummaryForExperience, $companyMatches, PREG_SET_ORDER);

                foreach ($companyMatches as $match) {
                    $company = trim($match[1]);
                    $position = trim($match[2]);
                    // Clean up the position to remove extra details
                    $position = preg_replace('/\s*\([^)]+\)/', '', $position); // Remove anything in parentheses
                    $position = trim($position);
                    if (!empty($company) && !empty($position)) {
                        $previousExperience[$company] = $position;
                    }
                }

                // If no companies were matched, try a more general pattern to catch remaining entries
                if (empty($previousExperience)) {
                    // General pattern to match "Company Name: Position" format anywhere in the text
                    $generalPattern = '/([A-Za-z\s&.`\'\-]+[A-Za-z][^:\n]*?)\s*:\s*([^(]+)/';
                    preg_match_all($generalPattern, $careerSummaryForExperience, $generalMatches, PREG_SET_ORDER);

                    foreach ($generalMatches as $match) {
                        $company = trim($match[1]);
                        $position = trim($match[2]);
                        // Clean up the position to remove extra details
                        $position = preg_replace('/\s*\([^)]+\)/', '', $position); // Remove anything in parentheses
                        $position = trim($position);
                        if (!empty($company) && !empty($position)) {
                            $previousExperience[$company] = $position;
                        }
                    }
                }

                // If still no experience years found, try to extract from the career summary as backup
                if ($experience_years == 0) {
                    \Log::info('Trying to extract experience from career summary as backup');
                    if (preg_match('/Total Experience:\s*(\d+)\+?\s*Year[s]?/i', $careerSummary, $expMatches)) {
                        $experience_years = (int)$expMatches[1];
                        \Log::info('Found experience in career summary: ' . $experience_years);
                    }
                }

                // Create candidate data
                $candidateData = [
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'experience_years' => $experience_years,
                    'age' => $age,
                    'previous_experience' => $previousExperience,
                ];

                // Check if candidate with this email already exists
                if (!empty($candidateData['email'])) {
                    $existingCandidate = Candidate::where('email', $candidateData['email'])->first();
                    if (!$existingCandidate) {
                        $candidate = Candidate::create($candidateData);
                        \Log::info('Created candidate: ' . $candidate->id . ' - ' . $candidate->name);
                        $processedCount++;
                    } else {
                        \Log::info('Candidate with email ' . $candidateData['email'] . ' already exists, skipping');
                        $skippedCount++;
                    }
                } else {
                    \Log::info('No email found for candidate, skipping');
                    $skippedCount++;
                }
            } else {
                \Log::info('Row does not have valid Career Summary data, skipping');
                $skippedCount++;
            }
        }

        \Log::info("Import completed. Processed: $processedCount, Skipped: $skippedCount");

        } catch (\Exception $e) {
            \Log::error('Error importing Excel file: ' . $e->getMessage());
            return redirect()->route('candidates.index')->with('error', 'Error importing file: ' . $e->getMessage());
        }

        return redirect()->route('candidates.index')->with('success', "Candidates imported successfully. Processed: $processedCount, Skipped: $skippedCount");
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
            'candidate_ids' => 'required|array',
            'candidate_ids.*' => 'exists:candidates,id',
            'interview_date' => 'required|date|after:today'
        ]);

        Candidate::whereIn('id', $request->candidate_ids)
            ->update([
                'status' => 'interview_scheduled',
                'interview_date' => $request->interview_date
            ]);

        return redirect()->route('candidates.upcoming-interviews')->with('success', 'Interviews scheduled successfully.');
    }

    public function upcomingInterviews()
    {
        $candidates = Candidate::where('status', 'interview_scheduled')
            ->where('interview_date', '>=', now())
            ->orderBy('interview_date', 'asc')
            ->get();
        return view('candidates.upcoming', compact('candidates'));
    }

    public function completedInterviews()
    {
        $candidates = Candidate::where('status', 'interview_completed')
            ->orWhere(function($query) {
                $query->where('status', 'interview_scheduled')
                      ->where('interview_date', '<', now());
            })
            ->get();

        // Update status for past interviews
        Candidate::where('status', 'interview_scheduled')
            ->where('interview_date', '<', now())
            ->update(['status' => 'interview_completed']);

        return view('candidates.completed', compact('candidates'));
    }

    public function markInterviewStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:passed,failed'
        ]);

        $candidate = Candidate::findOrFail($id);
        $candidate->update([
            'status' => $request->status === 'passed' ? 'passed' : 'failed',
            'interview_date' => now()
        ]);

        return redirect()->back()->with('success', 'Interview status updated successfully.');
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
}
