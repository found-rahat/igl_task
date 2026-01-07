@extends('layouts.app')

@section('title', 'All Candidates')

@section('content')
    <div style="width: 100%; padding: 0 1.5rem;">

        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.5rem; font-weight: bold; color: #1f2937;">All Candidates</h2>

            <a href="{{ route('candidates.import.form') }}"
                style="display: inline-block;
                  background-color: #16a34a;
                  color: #fff;
                  padding: 0.5rem 1rem;
                  border-radius: 0.375rem;
                  font-size: 0.875rem;
                  text-decoration: none;
                  transition: background-color 0.2s;"
                onmouseover="this.style.backgroundColor='#15803d'" onmouseout="this.style.backgroundColor='#16a34a'">
                Import from Excel
            </a>
        </div>

        <!-- Status Filter -->
        <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.25rem;">
            @php
                $filters = [
                    'all' => ['label' => 'All', 'bg' => '#1f2937', 'text' => '#ffffff', 'hover' => '#e5e7eb'],
                    'pending' => [
                        'label' => 'Pending',
                        'bg' => '#f59e0b',
                        'text' => '#ffffff',
                        'hover' => '#fde68a',
                        'inactiveBg' => '#fef3c7',
                        'inactiveText' => '#78350f',
                    ],
                    'hired' => [
                        'label' => 'Hired',
                        'bg' => '#16a34a',
                        'text' => '#ffffff',
                        'hover' => '#a7f3d0',
                        'inactiveBg' => '#d1fae5',
                        'inactiveText' => '#065f46',
                    ],
                    'rejected' => [
                        'label' => 'Rejected',
                        'bg' => '#dc2626',
                        'text' => '#ffffff',
                        'hover' => '#fecaca',
                        'inactiveBg' => '#fee2e2',
                        'inactiveText' => '#991b1b',
                    ],
                ];
            @endphp

            @foreach ($filters as $key => $filter)
                @php
                    $active = request('status') === $key || ($key === 'all' && request('status') === null);
                    $bg = $active ? $filter['bg'] : $filter['inactiveBg'] ?? '#f3f4f6';
                    $color = $active ? $filter['text'] : $filter['inactiveText'] ?? '#4b5563';
                    $hover = $filter['hover'] ?? $bg;
                    $url = $key === 'all' ? route('candidates.index') : route('candidates.index', ['status' => $key]);
                @endphp

                <a href="{{ $url }}"
                    style="display: inline-block;
                      padding: 0.5rem 1rem;
                      border-radius: 9999px;
                      font-size: 0.875rem;
                      font-weight: 500;
                      text-decoration: none;
                      color: {{ $color }};
                      background-color: {{ $bg }};
                      transition: background-color 0.2s;"
                    onmouseover="this.style.backgroundColor='{{ $hover }}'"
                    onmouseout="this.style.backgroundColor='{{ $bg }}'">
                    {{ $filter['label'] }}
                </a>
            @endforeach
        </div>

        <!-- Table -->
        <div
            style="background-color: #fff; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                <thead style="background-color: #f3f4f6;">
                    <tr>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: #374151;">Name</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: #374151;">Email</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: #374151;">Phone</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: #374151;">Experience
                        </th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: #374151;">Status</th>
                        <th style="padding: 1rem 1.5rem; text-align: right; font-weight: 600; color: #374151;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($candidates as $candidate)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 1rem 1.5rem; font-weight: 500; color: #1f2937;">{{ $candidate->name }}</td>
                            <td style="padding: 1rem 1.5rem; color: #4b5563;">{{ $candidate->email }}</td>
                            <td style="padding: 1rem 1.5rem; color: #4b5563;">{{ $candidate->phone }}</td>
                            <td style="padding: 1rem 1.5rem; color: #4b5563;">{{ $candidate->experience_years }} yrs</td>
                            <td style="padding: 1rem 1.5rem;">
                                @php
                                    $statusColors = [
                                        'pending' => ['bg' => '#fef3c7', 'text' => '#78350f'],
                                        'hired' => ['bg' => '#d1fae5', 'text' => '#065f46'],
                                        'rejected' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                                        'default' => ['bg' => '#f3f4f6', 'text' => '#374151'],
                                    ];
                                    $status = $statusColors[$candidate->status] ?? $statusColors['default'];
                                @endphp
                                <span
                                    style="
                                display: inline-block;
                                padding: 0.25rem 0.75rem;
                                font-size: 0.75rem;
                                font-weight: 600;
                                border-radius: 9999px;
                                background-color: {{ $status['bg'] }};
                                color: {{ $status['text'] }};
                            ">
                                    {{ ucfirst($candidate->status) }}
                                </span>
                            </td>
                            <td style="padding: 1rem 1.5rem; text-align: right;">
                                <div class="dropdown-container" style="position: relative; display: inline-block; text-align: left;">
                                    <button type="button" onclick="toggleDropdown({{ $candidate->id }}, event)"
                                        style="color:#4b5563; background:none; border:none; cursor:pointer;">
                                        <svg style="width: 1.25rem; height: 1.25rem;" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M6 10a2 2 0 114 0 2 2 0 01-4 0zm4-6a2 2 0 114 0 2 2 0 01-4 0zm0 12a2 2 0 114 0 2 2 0 01-4 0z" />
                                        </svg>
                                    </button>
                                    <div id="dropdown-{{ $candidate->id }}"
                                        style="display: none; position: absolute; right: 0; margin-top: 0.5rem; width: 11rem; background:#fff; border-radius:0.375rem; box-shadow:0 1px 3px rgba(0,0,0,0.1); border:1px solid #e5e7eb; z-index:50;">
                                        <a href="{{ route('candidates.show', $candidate) }}"
                                            style="display:block; padding:0.5rem 1rem; font-size:0.875rem; color:#4b5563; text-decoration:none;"
                                            onmouseover="this.style.backgroundColor='#f3f4f6'"
                                            onmouseout="this.style.backgroundColor='transparent'">View</a>
                                        <a href="{{ route('candidates.edit', $candidate) }}"
                                            style="display:block; padding:0.5rem 1rem; font-size:0.875rem; color:#4b5563; text-decoration:none;"
                                            onmouseover="this.style.backgroundColor='#f3f4f6'"
                                            onmouseout="this.style.backgroundColor='transparent'">Edit</a>
                                        <!-- Status Update Form -->
                                        <form method="POST" action="{{ route('candidates.mark.status', $candidate->id) }}" class="block" style="margin: 0;" id="status-form-{{ $candidate->id }}">
                                            @csrf
                                            <select name="status" class="w-full text-sm border-0 rounded-none" style="padding: 0.5rem 1rem; background: none; cursor: pointer;" onchange="document.getElementById('status-form-{{ $candidate->id }}').submit();">
                                                <option value="" disabled selected>Update Status</option>
                                                <option value="pending" {{ $candidate->status !== 'pending' ? '' : 'disabled' }}>Pending</option>
                                                <option value="hired" {{ $candidate->status !== 'hired' ? '' : 'disabled' }}>Hired</option>
                                                <option value="rejected" {{ $candidate->status !== 'rejected' ? '' : 'disabled' }}>Rejected</option>
                                                <option value="interview_scheduled" {{ $candidate->status !== 'interview_scheduled' ? '' : 'disabled' }}>Interview Scheduled</option>
                                                <option value="interview_completed" {{ $candidate->status !== 'interview_completed' ? '' : 'disabled' }}>Interview Completed</option>
                                                <option value="passed" {{ $candidate->status !== 'passed' ? '' : 'disabled' }}>Passed</option>
                                                <option value="failed" {{ $candidate->status !== 'failed' ? '' : 'disabled' }}>Failed</option>
                                                <option value="second_interview_scheduled" {{ $candidate->status !== 'second_interview_scheduled' ? '' : 'disabled' }}>Second Interview Scheduled</option>
                                            </select>
                                        </form>
                                        <form action="{{ route('candidates.destroy', $candidate) }}" method="POST"
                                            onsubmit="return confirm('Delete this candidate?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                style="width:100%; text-align:left; padding:0.5rem 1rem; font-size:0.875rem; color:#dc2626; background:none; border:none; cursor:pointer;"
                                                onmouseover="this.style.backgroundColor='#f3f4f6'"
                                                onmouseout="this.style.backgroundColor='transparent'">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding:1.5rem; text-align:center; color:#6b7280;">
                                No candidates found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div style="margin-top: 1.5rem;">
            {{ $candidates->links() }}
        </div>
    </div>

    <!-- JS for dropdown -->
    <script>
        function toggleDropdown(id, event) {
            event.preventDefault(); // prevent default action
            event.stopPropagation(); // prevent the click from bubbling

            // Close all other dropdowns
            document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
                if (el.id !== 'dropdown-' + id) el.style.display = 'none';
            });

            // Toggle current dropdown
            const el = document.getElementById('dropdown-' + id);
            el.style.display = (el.style.display === 'block') ? 'none' : 'block';
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            // Check if the click is inside a dropdown
            if (!e.target.closest('.dropdown-container') && !e.target.closest('[id^="dropdown-"]')) {
                document.querySelectorAll('[id^="dropdown-"]').forEach(el => el.style.display = 'none');
            }
        });
    </script>

@endsection
