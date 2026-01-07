@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">Manage Candidates</h3>
            <p class="text-gray-600">View, edit, and manage all candidate information</p>
            <div class="mt-2 space-y-1">
                <a href="{{ route('candidates.index') }}" class="block text-blue-600 hover:underline">All Candidates</a>
                <a href="{{ route('candidates.hired') }}" class="block text-blue-600 hover:underline">Hired Candidates</a>
                <a href="{{ route('candidates.rejected') }}" class="block text-blue-600 hover:underline">Rejected Candidates</a>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">Schedule Interviews</h3>
            <p class="text-gray-600">Schedule interviews for candidates</p>
            <a href="{{ route('candidates.schedule.form') }}" class="block text-blue-600 hover:underline mt-2">Schedule Interviews</a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">Interview Management</h3>
            <p class="text-gray-600">Manage upcoming and completed interviews</p>
            <div class="mt-2 space-y-1">
                <a href="{{ route('candidates.upcoming-interviews') }}" class="block text-blue-600 hover:underline">Upcoming Interviews</a>
                <a href="{{ route('candidates.completed-interviews') }}" class="block text-blue-600 hover:underline">Completed Interviews</a>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">Import Candidates</h3>
            <p class="text-gray-600">Import candidate data from Excel</p>
            <a href="{{ route('candidates.import.form') }}" class="block text-blue-600 hover:underline mt-2">Import Candidates</a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">Reports</h3>
            <p class="text-gray-600">Download reports and analytics</p>
            <a href="{{ route('candidates.download.phones') }}" class="block text-blue-600 hover:underline mt-2">Download Phone Numbers</a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">System Status</h3>
            <p class="text-gray-600">View system statistics</p>
            <div class="mt-2 space-y-1">
                <p class="text-gray-700">Total Candidates: {{ \App\Models\Candidate::count() }}</p>
                <p class="text-gray-700">Pending: {{ \App\Models\Candidate::where('status', 'pending')->count() }}</p>
                <p class="text-gray-700">Hired: {{ \App\Models\Candidate::where('status', 'hired')->count() }}</p>
            </div>
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
                    <p class="text-gray-700">New candidate registered</p>
                    <p class="text-gray-500 text-sm">{{ \App\Models\Candidate::latest()->first() ? \App\Models\Candidate::latest()->first()->created_at->diffForHumans() : 'No recent activity' }}</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="bg-green-100 p-2 rounded-full mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-700">Interview scheduled</p>
                    <p class="text-gray-500 text-sm">{{ \App\Models\Candidate::where('status', 'interview_scheduled')->latest()->first() ? \App\Models\Candidate::where('status', 'interview_scheduled')->latest()->first()->updated_at->diffForHumans() : 'No recent interviews' }}</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="bg-yellow-100 p-2 rounded-full mr-3">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-gray-700">Candidate hired</p>
                    <p class="text-gray-500 text-sm">{{ \App\Models\Candidate::where('status', 'hired')->latest()->first() ? \App\Models\Candidate::where('status', 'hired')->latest()->first()->updated_at->diffForHumans() : 'No recent hires' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection