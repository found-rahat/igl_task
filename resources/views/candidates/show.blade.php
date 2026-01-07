@extends('layouts.app')

@section('title', 'View Candidate')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Candidate Details</h2>
        <div>
            <a href="{{ route('candidates.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mr-2">Back to List</a>
            <a href="{{ route('candidates.edit', $candidate) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Edit</a>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Name</label>
                <p class="bg-gray-50 p-2 rounded">{{ $candidate->name }}</p>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Email</label>
                <p class="bg-gray-50 p-2 rounded">{{ $candidate->email }}</p>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Phone</label>
                <p class="bg-gray-50 p-2 rounded">{{ $candidate->phone }}</p>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Age</label>
                <p class="bg-gray-50 p-2 rounded">{{ $candidate->age }}</p>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Years of Experience</label>
                <p class="bg-gray-50 p-2 rounded">{{ $candidate->experience_years }}</p>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Status</label>
                <p class="bg-gray-50 p-2 rounded">
                    <span class="px-2 py-1 text-sm rounded-full 
                        @switch($candidate->status)
                            @case('pending')
                                bg-yellow-100 text-yellow-800
                                @break
                            @case('hired')
                                bg-green-100 text-green-800
                                @break
                            @case('rejected')
                                bg-red-100 text-red-800
                                @break
                            @case('interview_scheduled')
                                bg-blue-100 text-blue-800
                                @break
                            @case('interview_completed')
                                bg-purple-100 text-purple-800
                                @break
                            @case('passed')
                                bg-indigo-100 text-indigo-800
                                @break
                            @case('failed')
                                bg-pink-100 text-pink-800
                                @break
                            @default
                                bg-gray-100 text-gray-800
                        @endswitch
                    ">
                        {{ ucfirst(str_replace('_', ' ', $candidate->status)) }}
                    </span>
                </p>
            </div>
            
            <div class="mb-4 md:col-span-2">
                <label class="block text-gray-700 font-medium mb-1">Previous Experience</label>
                <div class="bg-gray-50 p-2 rounded">
                    @if($candidate->previous_experience)
                        @foreach($candidate->previous_experience as $institute => $position)
                            <div class="mb-2">
                                <span class="font-medium">{{ $institute }}</span>: {{ $position }}
                            </div>
                        @endforeach
                    @else
                        <p>No previous experience recorded.</p>
                    @endif
                </div>
            </div>
            
            @if($candidate->interview_date)
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Interview Date</label>
                <p class="bg-gray-50 p-2 rounded">{{ $candidate->interview_date->format('Y-m-d H:i') }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection