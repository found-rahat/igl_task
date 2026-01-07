@extends('layouts.app')

@section('title', 'Schedule Interviews')

@section('content')
    <div class="max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold mb-6">Schedule Interviews</h2>

        <div class="bg-white p-6 rounded-lg shadow">
            <form action="{{ route('candidates.schedule.interview') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label for="interview_date" class="block text-gray-700 font-medium mb-2">Interview Date & Time</label>
                    <input type="datetime-local" name="interview_date" id="interview_date"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    @error('interview_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Range Selection Section -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium mb-4">Range Selection</h3>
                    <div class="flex items-center space-x-4 mb-4">
                        <div>
                            <label for="range_start" class="block text-sm text-gray-600 mb-1">From</label>
                            <input type="number" name="range_start" id="range_start" min="1"
                                max="{{ $candidates->count() }}" placeholder="Start"
                                class="w-24 px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div class="pt-5">-</div>
                        <div>
                            <label for="range_end" class="block text-sm text-gray-600 mb-1">To</label>
                            <input type="number" name="range_end" id="range_end" min="1"
                                max="{{ $candidates->count() }}" placeholder="End"
                                class="w-24 px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                        <button type="button" id="apply-range"
                            class="mt-6 bg-gray-200 text-gray-800 px-3 py-2 rounded hover:bg-gray-300">Apply Range</button>
                    </div>
                    <p class="text-sm text-gray-500">Select candidates by range (e.g., 2-10 to select candidates 2 through
                        10)</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-medium mb-4">Select Candidates</h3>
                    <div class="flex justify-between items-center mb-2">
                        <span>Select All: <input type="checkbox" id="select-all" class="mr-2"></span>
                        <span>Total: {{ $candidates->count() }} candidates</span>
                    </div>
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-96 overflow-y-auto p-2 border border-gray-200 rounded">
                        @forelse($candidates as $index => $candidate)
                            <div class="flex items-start p-3 border border-gray-200 rounded candidate-item"
                                data-index="{{ $index + 1 }}">
                                <input type="checkbox" name="candidate_ids[]" value="{{ $candidate->id }}"
                                    id="candidate_{{ $candidate->id }}" class="mt-1 mr-2 candidate-checkbox">
                                <label for="candidate_{{ $candidate->id }}" class="flex-1">
                                    <div class="font-medium">#{{ $index + 1 }} {{ $candidate->name }}</div>
                                    <div class="text-sm text-gray-600">{{ $candidate->email }}</div>
                                    <div class="text-sm text-gray-600">{{ $candidate->phone }}</div>
                                </label>
                            </div>
                        @empty
                            <p class="text-gray-500 col-span-3">No candidates available for interview scheduling.</p>
                        @endforelse
                    </div>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Schedule
                        Interviews</button>
                    <a href="{{ route('candidates.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all functionality
            const selectAllCheckbox = document.getElementById('select-all');
            const candidateCheckboxes = document.querySelectorAll('.candidate-checkbox');

            selectAllCheckbox.addEventListener('change', function() {
                candidateCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });

            // Range selection functionality
            document.getElementById('apply-range').addEventListener('click', function() {
                const rangeStart = parseInt(document.getElementById('range_start').value);
                const rangeEnd = parseInt(document.getElementById('range_end').value);

                if (isNaN(rangeStart) || isNaN(rangeEnd) || rangeStart < 1 || rangeEnd < rangeStart) {
                    alert('Please enter valid range values (e.g., start <= end)');
                    return;
                }

                // Uncheck all first
                candidateCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });

                // Check candidates within the range
                document.querySelectorAll('.candidate-item').forEach(item => {
                    const index = parseInt(item.getAttribute('data-index'));
                    if (index >= rangeStart && index <= rangeEnd) {
                        const checkbox = item.querySelector('.candidate-checkbox');
                        if (checkbox) {
                            checkbox.checked = true;
                        }
                    }
                });

                // Update select all checkbox state
                updateSelectAllState();
            });

            // Update select all checkbox when individual checkboxes change
            candidateCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectAllState);
            });

            function updateSelectAllState() {
                const checkedCount = document.querySelectorAll('.candidate-checkbox:checked').length;
                selectAllCheckbox.checked = checkedCount === candidateCheckboxes.length;
            }
        });
    </script>
@endsection
