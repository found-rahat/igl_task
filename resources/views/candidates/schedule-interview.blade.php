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
                <input type="datetime-local" name="interview_date" id="interview_date" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                @error('interview_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <h3 class="text-lg font-medium mb-4">Select Candidates</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-96 overflow-y-auto p-2 border border-gray-200 rounded">
                    @forelse($candidates as $candidate)
                        <div class="flex items-start p-3 border border-gray-200 rounded">
                            <input type="checkbox" name="candidate_ids[]" value="{{ $candidate->id }}" id="candidate_{{ $candidate->id }}" class="mt-1 mr-2">
                            <label for="candidate_{{ $candidate->id }}" class="flex-1">
                                <div class="font-medium">{{ $candidate->name }}</div>
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
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Schedule Interviews</button>
                <a href="{{ route('candidates.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection