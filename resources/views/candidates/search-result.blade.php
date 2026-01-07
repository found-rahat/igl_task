<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Candidate Result - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8fafc;
        }
        .card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 2rem;
        }
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 9999px;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen py-12">
        <div class="max-w-4xl mx-auto px-4">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Application Status</h1>
                <p class="text-gray-600">Your application details</p>
            </div>
            
            <div class="card">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Personal Information</h2>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Name</label>
                                <p class="text-lg font-medium text-gray-800">{{ $candidate->name }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Email</label>
                                <p class="text-lg text-gray-800">{{ $candidate->email }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Phone</label>
                                <p class="text-lg text-gray-800">{{ $candidate->phone }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Age</label>
                                <p class="text-lg text-gray-800">{{ $candidate->age }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Application Details</h2>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Experience</label>
                                <p class="text-lg text-gray-800">{{ $candidate->experience_years }} years</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Status</label>
                                <span class="status-badge 
                                    @switch($candidate->status)
                                        @case('pending')
                                            bg-yellow-100 text-yellow-800
                                            @break
                                        @case('passed')
                                            bg-green-100 text-green-800
                                            @break
                                        @case('failed')
                                            bg-red-100 text-red-800
                                            @break
                                        @case('hired')
                                            bg-blue-100 text-blue-800
                                            @break
                                        @case('rejected')
                                            bg-gray-100 text-gray-800
                                            @break
                                        @case('interview_scheduled')
                                            bg-indigo-100 text-indigo-800
                                            @break
                                        @case('interview_completed')
                                            bg-purple-100 text-purple-800
                                            @break
                                        @case('second_interview_scheduled')
                                            bg-orange-100 text-orange-800
                                            @break
                                        @default
                                            bg-gray-100 text-gray-800
                                    @endswitch
                                ">
                                    {{ ucfirst(str_replace('_', ' ', $candidate->status)) }}
                                </span>
                            </div>
                            @if($candidate->interview_date)
                            <div>
                                <label class="text-sm font-medium text-gray-500">Interview Date</label>
                                <p class="text-lg text-gray-800">{{ $candidate->interview_date->format('F j, Y g:i A') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                @if(!empty($candidate->previous_experience))
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Previous Experience</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Institute</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    $experienceData = $candidate->previous_experience;
                                    if (is_string($experienceData)) {
                                        $experienceData = json_decode($experienceData, true);
                                    }
                                @endphp
                                @foreach($experienceData as $institute => $position)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $institute }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $position }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                
                <div class="text-center">
                    <a href="{{ route('candidate.search.form') }}" class="inline-block bg-gray-600 text-white py-2 px-6 rounded-lg hover:bg-gray-700 transition-colors">
                        Search Another Candidate
                    </a>
                </div>
            </div>
            
            <div class="mt-8 text-center text-sm text-gray-600">
                <p>© {{ date('Y') }} Company Name. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>