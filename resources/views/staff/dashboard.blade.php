@extends('layouts.app')

@section('title', 'Staff Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Staff Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">View Candidates</h3>
            <p class="text-gray-600">Browse and view all candidate information</p>
            <a href="{{ route('candidates.index') }}" class="text-blue-600 hover:underline mt-2 inline-block">View Candidates</a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">Import Candidates</h3>
            <p class="text-gray-600">Upload candidate data from Excel</p>
            <a href="{{ route('candidates.import.form') }}" class="text-blue-600 hover:underline mt-2 inline-block">Import Candidates</a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">View Reports</h3>
            <p class="text-gray-600">Access system reports and analytics</p>
            <a href="#" class="text-blue-600 hover:underline mt-2 inline-block">View Reports</a>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="mt-8 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Recent Activity</h3>
        <div class="space-y-4">
            <div class="flex items-start">
                <div class="bg-blue-100 p-2 rounded-full mr-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-700">New candidate imported</p>
                    <p class="text-gray-500 text-sm">Just now</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="bg-green-100 p-2 rounded-full mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-700">Report generated</p>
                    <p class="text-gray-500 text-sm">10 minutes ago</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection