@extends('layouts.app')

@section('title', 'Schedule Second Interview')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Schedule Second Interview</h2>

    <div class="bg-white p-6 rounded-lg shadow">
        <div class="mb-6 p-4 bg-blue-50 rounded-lg">
            <h3 class="font-medium text-blue-800">Candidate Information</h3>
            <p class="text-gray-700"><span class="font-medium">Name:</span> {{ $candidate->name }}</p>
            <p class="text-gray-700"><span class="font-medium">Email:</span> {{ $candidate->email }}</p>
            <p class="text-gray-700"><span class="font-medium">Phone:</span> {{ $candidate->phone }}</p>
            <p class="text-gray-700"><span class="font-medium">Status:</span> 
                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                    {{ ucfirst(str_replace('_', ' ', $candidate->status)) }}
                </span>
            </p>
        </div>

        <form action="{{ route('candidates.schedule.second.interview', $candidate) }}" method="POST">
            @csrf
            <div class="mb-6">
                <label for="interview_date" class="block text-gray-700 font-medium mb-2">Second Interview Date & Time</label>
                <input type="datetime-local" name="interview_date" id="interview_date" class="w-full px-3 py-2 border border-gray-300 rounded-md" required min="{{ date('Y-m-d\TH:i', strtotime('+1 day')) }}">
                @error('interview_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Schedule Second Interview</button>
                <a href="{{ route('candidates.completed-interviews') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection