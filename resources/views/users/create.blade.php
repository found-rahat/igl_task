@extends('layouts.app')

@section('title', 'Add Staff Member')

@section('content')
    <div class="w-full max-w-4xl mx-auto px-6 py-8">

        <!-- Card -->
        <div class="bg-white shadow-lg rounded-lg">

            <!-- Header -->
            <div class="border-b px-6 py-4">
                <h2 class="text-xl font-semibold text-gray-800">
                    Add Staff Member
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Create a new staff account with login credentials
                </p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('users.store') }}" class="px-6 py-6 space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Full Name
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm
                           focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                        placeholder="Enter full name" required>
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email Address
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm
                           focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                        placeholder="example@email.com" required>
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Password
                        </label>
                        <input type="password" name="password"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm
                               focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            placeholder="********" required>
                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Confirm Password
                        </label>
                        <input type="password" name="password_confirmation"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm
                               focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            placeholder="********" required>
                    </div>
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Role
                    </label>
                    <select name="role"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm
                           focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        <option value="staff" selected>Staff</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3 pt-4 border-t">
                    <a href="{{ route('users.index') }}"
                        class="px-4 py-2 rounded-md border border-gray-300 text-sm text-gray-700 hover:bg-gray-100">
                        Cancel
                    </a>

                    <button type="submit"
                        class="px-5 py-2 rounded-md bg-blue-600 text-sm text-white font-medium hover:bg-blue-700">
                        Add Staff
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
