@extends('layouts.app')

@section('title', 'Hired Candidates')

@section('content')
<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Hired Candidates</h2>
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Experience</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hire Date</th>
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
                    <td class="px-6 py-4 whitespace-nowrap">{{ $candidate->updated_at->format('Y-m-d') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('candidates.show', $candidate) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No hired candidates found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection