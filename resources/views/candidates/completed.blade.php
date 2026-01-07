@extends('layouts.app')

@section('title', 'Completed Interviews')

@section('content')
<div class="max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Completed Interviews</h2>
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Interview Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($candidates as $candidate)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $candidate->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $candidate->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full 
                            @switch($candidate->status)
                                @case('interview_completed')
                                    bg-purple-100 text-purple-800
                                    @break
                                @case('passed')
                                    bg-green-100 text-green-800
                                    @break
                                @case('failed')
                                    bg-red-100 text-red-800
                                    @break
                                @default
                                    bg-gray-100 text-gray-800
                            @endswitch
                        ">
                            {{ ucfirst(str_replace('_', ' ', $candidate->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $candidate->interview_date ? $candidate->interview_date->format('Y-m-d H:i') : 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('candidates.show', $candidate) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                        @if($candidate->status === 'interview_completed')
                            <form method="POST" action="{{ route('candidates.mark.status', $candidate->id) }}" class="inline">
                                @csrf
                                <select name="status" class="text-sm border rounded px-2 py-1 mr-1">
                                    <option value="">Mark as...</option>
                                    <option value="passed">Passed</option>
                                    <option value="failed">Failed</option>
                                </select>
                                <button type="submit" class="text-xs bg-blue-500 text-white px-2 py-1 rounded">Update</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No completed interviews.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection