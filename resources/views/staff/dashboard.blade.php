@extends('layouts.app')

@section('title', 'Staff Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Staff Dashboard</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">Upload Candidates</h3>
            <p class="text-gray-600">Upload Excel file with candidate information</p>
            <a href="#" class="text-blue-600 hover:underline mt-2 inline-block">Upload File</a>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">View Candidates</h3>
            <p class="text-gray-600">View all candidate information</p>
            <a href="#" class="text-blue-600 hover:underline mt-2 inline-block">View Candidates</a>
        </div>
    </div>
    
    <!-- Recent Uploads Section -->
    <div class="mt-8 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Recent Uploads</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between border-b pb-2">
                <div>
                    <p class="font-medium">candidates_list.xlsx</p>
                    <p class="text-gray-500 text-sm">Uploaded 2 hours ago</p>
                </div>
                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Processed</span>
            </div>
            <div class="flex items-center justify-between border-b pb-2">
                <div>
                    <p class="font-medium">new_applicants.xlsx</p>
                    <p class="text-gray-500 text-sm">Uploaded 1 day ago</p>
                </div>
                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Processing</span>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-medium">backup_data.xlsx</p>
                    <p class="text-gray-500 text-sm">Uploaded 2 days ago</p>
                </div>
                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Processed</span>
            </div>
        </div>
    </div>
</div>
@endsection