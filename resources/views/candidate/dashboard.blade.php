@extends('layouts.app')

@section('title', 'Candidate Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Candidate Dashboard</h2>
    
    <div class="bg-white p-6 rounded-lg shadow max-w-2xl mx-auto">
        <h3 class="text-lg font-semibold mb-4">Your Application Status</h3>
        
        <div class="mb-4">
            <p class="text-gray-700"><span class="font-medium">Status:</span> 
                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded">Application Submitted</span>
            </p>
        </div>
        
        <div class="mb-4">
            <p class="text-gray-700"><span class="font-medium">Next Step:</span> Awaiting Initial Review</p>
        </div>
        
        <div class="mb-4">
            <p class="text-gray-700"><span class="font-medium">Applied Date:</span> January 6, 2026</p>
        </div>
        
        <div class="mt-6">
            <h4 class="font-medium mb-2">Interview Schedule</h4>
            <p class="text-gray-600">No interviews scheduled yet. Please check back later.</p>
        </div>
    </div>
    
    <!-- Application History -->
    <div class="mt-8 bg-white p-6 rounded-lg shadow max-w-2xl mx-auto">
        <h3 class="text-lg font-semibold mb-4">Application History</h3>
        <div class="space-y-4">
            <div class="flex items-start">
                <div class="bg-blue-100 p-2 rounded-full mr-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-700">Application submitted successfully</p>
                    <p class="text-gray-500 text-sm">January 6, 2026</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="bg-gray-100 p-2 rounded-full mr-3">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-700">Application under review</p>
                    <p class="text-gray-500 text-sm">Pending</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection