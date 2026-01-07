@extends('layouts.app')

@section('title', 'Edit Candidate')

@section('content')
<div class="max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Edit Candidate</h2>
    
    <div class="bg-white p-6 rounded-lg shadow">
        <form action="{{ route('candidates.update', $candidate) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $candidate->name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email *</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $candidate->email) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-medium mb-2">Phone *</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $candidate->phone) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="age" class="block text-gray-700 font-medium mb-2">Age *</label>
                    <input type="number" name="age" id="age" value="{{ old('age', $candidate->age) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md" required min="18">
                    @error('age')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="experience_years" class="block text-gray-700 font-medium mb-2">Years of Experience *</label>
                    <input type="number" name="experience_years" id="experience_years" value="{{ old('experience_years', $candidate->experience_years) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md" required min="0">
                    @error('experience_years')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4 md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2">Previous Experience</label>
                    <div id="experience-fields">
                        @if($candidate->previous_experience)
                            @foreach($candidate->previous_experience as $institute => $position)
                                <div class="flex space-x-2 mb-2">
                                    <input type="text" name="previous_experience[][institute]" value="{{ $institute }}" placeholder="Institute Name" class="flex-1 px-3 py-2 border border-gray-300 rounded-md" required>
                                    <input type="text" name="previous_experience[][position]" value="{{ $position }}" placeholder="Position" class="flex-1 px-3 py-2 border border-gray-300 rounded-md" required>
                                    <button type="button" class="remove-exp bg-red-500 text-white px-3 py-2 rounded" onclick="removeExperience(this)">Remove</button>
                                </div>
                            @endforeach
                        @else
                            <div class="flex space-x-2 mb-2">
                                <input type="text" name="previous_experience[][institute]" placeholder="Institute Name" class="flex-1 px-3 py-2 border border-gray-300 rounded-md" required>
                                <input type="text" name="previous_experience[][position]" placeholder="Position" class="flex-1 px-3 py-2 border border-gray-300 rounded-md" required>
                                <button type="button" class="remove-exp bg-red-500 text-white px-3 py-2 rounded" onclick="removeExperience(this)">Remove</button>
                            </div>
                        @endif
                    </div>
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mt-2" onclick="addExperience()">Add Experience</button>
                    @error('previous_experience')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="flex space-x-4 mt-6">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Candidate</button>
                <a href="{{ route('candidates.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    function addExperience() {
        const container = document.getElementById('experience-fields');
        const div = document.createElement('div');
        div.className = 'flex space-x-2 mb-2';
        div.innerHTML = `
            <input type="text" name="previous_experience[][institute]" placeholder="Institute Name" class="flex-1 px-3 py-2 border border-gray-300 rounded-md" required>
            <input type="text" name="previous_experience[][position]" placeholder="Position" class="flex-1 px-3 py-2 border border-gray-300 rounded-md" required>
            <button type="button" class="remove-exp bg-red-500 text-white px-3 py-2 rounded" onclick="removeExperience(this)">Remove</button>
        `;
        container.appendChild(div);
    }
    
    function removeExperience(button) {
        button.parentElement.remove();
    }
</script>
@endsection