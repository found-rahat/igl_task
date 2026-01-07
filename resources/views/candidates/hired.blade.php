@extends('layouts.app')

@section('title', 'Hired Candidates')

@section('content')
    <div style="max-width:1200px; margin:0 auto; padding:1rem;">
        <h2 style="font-size:1.5rem; font-weight:bold; margin-bottom:1rem;">Hired Candidates</h2>

        <div style="background:#fff; border-radius:0.5rem; box-shadow:0 1px 3px rgba(0,0,0,0.1); overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; font-size:0.875rem;">
                <thead style="background:#f3f4f6;">
                    <tr>
                        <th style="padding:1rem 1.5rem; text-align:left; font-weight:600; color:#374151;">Name</th>
                        <th style="padding:1rem 1.5rem; text-align:left; font-weight:600; color:#374151;">Email</th>
                        <th style="padding:1rem 1.5rem; text-align:left; font-weight:600; color:#374151;">Phone</th>
                        <th style="padding:1rem 1.5rem; text-align:left; font-weight:600; color:#374151;">Experience</th>
                        <th style="padding:1rem 1.5rem; text-align:left; font-weight:600; color:#374151;">Hire Date</th>
                        <th style="padding:1rem 1.5rem; text-align:right; font-weight:600; color:#374151;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($candidates as $candidate)
                        <tr style="border-bottom:1px solid #e5e7eb;">
                            <td style="padding:1rem 1.5rem; font-weight:500; color:#1f2937;">{{ $candidate->name }}</td>
                            <td style="padding:1rem 1.5rem; color:#4b5563;">{{ $candidate->email }}</td>
                            <td style="padding:1rem 1.5rem; color:#4b5563;">{{ $candidate->phone }}</td>
                            <td style="padding:1rem 1.5rem; color:#4b5563;">{{ $candidate->experience_years }} years</td>
                            <td style="padding:1rem 1.5rem; color:#4b5563;">{{ $candidate->updated_at->format('Y-m-d') }}
                            </td>
                            <td style="padding:1rem 1.5rem; text-align:right; position:relative;">
                                <div style="position:relative; display:inline-block;">
                                    <button type="button" onclick="toggleDropdown({{ $candidate->id }}, event)"
                                        style="color:#4b5563; background:none; border:none; cursor:pointer;">
                                        <svg style="width:1.25rem; height:1.25rem;" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M6 10a2 2 0 114 0 2 2 0 01-4 0zm4-6a2 2 0 114 0 2 2 0 01-4 0zm0 12a2 2 0 114 0 2 2 0 01-4 0z" />
                                        </svg>
                                    </button>

                                    <div id="dropdown-{{ $candidate->id }}"
                                        style="display:none; position:absolute; right:0; margin-top:0.5rem; width:11rem; background:#fff; border-radius:0.375rem; box-shadow:0 1px 3px rgba(0,0,0,0.1); border:1px solid #e5e7eb; z-index:50;">
                                        <a href="{{ route('candidates.show', $candidate) }}"
                                            style="display:block; padding:0.5rem 1rem; font-size:0.875rem; color:#4b5563; text-decoration:none;"
                                            onmouseover="this.style.backgroundColor='#f3f4f6'"
                                            onmouseout="this.style.backgroundColor='transparent'">View</a>
                                        <a href="{{ route('candidates.edit', $candidate) }}"
                                            style="display:block; padding:0.5rem 1rem; font-size:0.875rem; color:#4b5563; text-decoration:none;"
                                            onmouseover="this.style.backgroundColor='#f3f4f6'"
                                            onmouseout="this.style.backgroundColor='transparent'">Edit</a>
                                        <form action="{{ route('candidates.mark.status', $candidate->id) }}" method="POST"
                                            style="margin:0;" id="status-form-{{ $candidate->id }}">
                                            @csrf
                                            <select name="status"
                                                style="width:100%; border:none; font-size:0.875rem; padding:0.5rem 1rem;"
                                                onchange="document.getElementById('status-form-{{ $candidate->id }}').submit();">
                                                <option value="" disabled selected>Update Status</option>
                                                <option value="pending" {{ $candidate->status !== 'pending' ? '' : 'disabled' }}>Pending</option>
                                                <option value="hired" {{ $candidate->status !== 'hired' ? '' : 'disabled' }}>Hired</option>
                                                <option value="rejected" {{ $candidate->status !== 'rejected' ? '' : 'disabled' }}>Rejected</option>
                                                <option value="interview_scheduled" {{ $candidate->status !== 'interview_scheduled' ? '' : 'disabled' }}>Interview Scheduled</option>
                                                <option value="interview_completed" {{ $candidate->status !== 'interview_completed' ? '' : 'disabled' }}>Interview Completed</option>
                                                <option value="passed" {{ $candidate->status !== 'passed' ? '' : 'disabled' }}>Passed</option>
                                                <option value="failed" {{ $candidate->status !== 'failed' ? '' : 'disabled' }}>Failed</option>
                                                <option value="second_interview_scheduled" {{ $candidate->status !== 'second_interview_scheduled' ? '' : 'disabled' }}>Second Interview Scheduled
                                                </option>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding:1rem 1.5rem; text-align:center; color:#6b7280;">No hired
                                candidates found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function toggleDropdown(id, event) {
            event.preventDefault();
            event.stopPropagation();
            document.querySelectorAll('[id^="dropdown-"]').forEach(d => {
                if (d.id !== 'dropdown-' + id) d.style.display = 'none';
            });
            const el = document.getElementById('dropdown-' + id);
            el.style.display = (el.style.display === 'block') ? 'none' : 'block';
        }
        document.addEventListener('click', function(e) {
            if (!e.target.closest('[id^="dropdown-"]') && !e.target.closest('button')) {
                document.querySelectorAll('[id^="dropdown-"]').forEach(d => d.style.display = 'none');
            }
        });
    </script>
@endsection
