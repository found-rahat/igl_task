@extends('layouts.app')

@section('title', 'Import Candidates')

@section('content')
<div class="max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Import Candidates from Excel</h2>
    
    <div class="bg-white p-6 rounded-lg shadow">
        <form action="{{ route('candidates.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="excel_file" class="block text-gray-700 font-medium mb-2">Excel File</label>
                <input type="file" name="excel_file" id="excel_file" class="w-full px-3 py-2 border border-gray-300 rounded-md" accept=".xlsx,.xls,.csv" required>
                <p class="text-gray-500 text-sm mt-1">Supported formats: XLSX, XLS, CSV</p>
            </div>
            
            <div class="mb-6">
                <h3 class="text-lg font-medium mb-2">Expected Excel Format:</h3>
                <p class="text-gray-600 mb-3">The Excel file should have the following columns:</p>
                <ul class="list-disc pl-6 text-gray-600 mb-3">
                    <li>Column A: Serial Number</li>
                    <li>Column B: Image Name (optional)</li>
                    <li>Column C: Career Summary (contains Name, Age, Location, University, Degree, Contact Info)</li>
                    <li>Column D: Experience And Application Status (contains company names, positions, and experience details)</li>
                    <li>Column E: Applied On</li>
                    <li>Column F: Remarks</li>
                </ul>
                <p class="text-gray-600">Example format in Career Summary column:</p>
                <pre class="bg-gray-100 p-3 rounded mt-2 text-sm">Name: John Doe
Age: 25.2
Location: New York, USA
University: University of California, Berkeley
Degree: Bachelor of Science (BSc)
Job Matching: 77%
+1 917-555-1234
johndoe@example.com</pre>
                <p class="text-gray-600 mt-2">Example format in Experience column:</p>
                <pre class="bg-gray-100 p-3 rounded mt-2 text-sm">TechWave Solutions: Software Engineer (2+ months)
SparkTech Innovations: Intern (4+ months)
Total Experience: 3+ Years
Salary: 30,000
Total Applied: 1</pre>
            </div>
            
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Import Candidates</button>
                <a href="{{ route('candidates.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection