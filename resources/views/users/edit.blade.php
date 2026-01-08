@extends('layouts.app')

@section('title', 'Edit Staff Member')

@section('content')
<div style="width: 100%; max-width: 600px; margin: 0 auto; padding: 0 1.5rem;">

    <!-- Header -->
    <div style="margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.5rem; font-weight: bold; color: #1f2937;">Edit Staff Member</h2>
        <p style="color: #4b5563; margin-top: 0.5rem;">Update the information for this staff member below.</p>
    </div>

    <!-- Form -->
    <div style="background-color: #fff; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 1.5rem;">
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1rem;">
                <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">Full Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                    style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;">
                @error('name')
                    <p style="margin-top: 0.25rem; font-size: 0.75rem; color: #ef4444;">{{ $message }}</p>
                @enderror
            </div>
            
            <div style="margin-bottom: 1rem;">
                <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                    style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;">
                @error('email')
                    <p style="margin-top: 0.25rem; font-size: 0.75rem; color: #ef4444;">{{ $message }}</p>
                @enderror
            </div>
            
            <div style="margin-bottom: 1rem;">
                <label for="role" style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">Role</label>
                <select id="role" name="role" required
                    style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;">
                    <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
                @error('role')
                    <p style="margin-top: 0.25rem; font-size: 0.75rem; color: #ef4444;">{{ $message }}</p>
                @enderror
            </div>
            
            <div style="margin-bottom: 1rem;">
                <label for="status" style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">Status</label>
                <select id="status" name="status" required
                    style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;">
                    <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p style="margin-top: 0.25rem; font-size: 0.75rem; color: #ef4444;">{{ $message }}</p>
                @enderror
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1.5rem;">
                <a href="{{ route('users.index') }}" 
                   style="display: inline-block; padding: 0.5rem 1rem; background-color: #6b7280; color: #fff; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;"
                   onmouseover="this.style.backgroundColor='#4b5563'" onmouseout="this.style.backgroundColor='#6b7280'">
                    Cancel
                </a>
                <button type="submit" 
                        style="display: inline-block; padding: 0.5rem 1rem; background-color: #16a34a; color: #fff; border: none; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem; cursor: pointer;"
                        onmouseover="this.style.backgroundColor='#15803d'" onmouseout="this.style.backgroundColor='#16a34a'">
                    Update Staff Member
                </button>
            </div>
        </form>
    </div>
</div>
@endsection