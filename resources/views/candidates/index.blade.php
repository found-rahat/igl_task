@extends('layouts.app')

@section('title', 'All Candidates')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">All Candidates</h2>
        <a href="{{ route('candidates.import.form') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Import from Excel</a>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Experience</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($candidates as $candidate)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $candidate->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $candidate->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $candidate->phone }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $candidate->experience_years }} years</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full 
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
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('candidates.show', $candidate) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                        <a href="{{ route('candidates.edit', $candidate) }}" class="text-green-600 hover:text-green-900 mr-3">Edit</a>
                        <form action="{{ route('candidates.destroy', $candidate) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this candidate?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No candidates found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection