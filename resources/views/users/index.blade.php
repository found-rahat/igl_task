@extends('layouts.app')

@section('title', 'Manage Staff')

@section('content')
    <div style="width: 100%; padding: 0 1.5rem;">

        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.5rem; font-weight: bold; color: #1f2937;">Manage Staff</h2>

            <a href="{{ route('users.create') }}"
                style="display: inline-block;
                  background-color: #16a34a;
                  color: #fff;
                  padding: 0.5rem 1rem;
                  border-radius: 0.375rem;
                  font-size: 0.875rem;
                  text-decoration: none;
                  transition: background-color 0.2s;"
                onmouseover="this.style.backgroundColor='#15803d'" onmouseout="this.style.backgroundColor='#16a34a'">
                Add Staff Member
            </a>
        </div>

        <!-- Table -->
        <div
            style="background-color: #fff; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                <thead style="background-color: #f3f4f6;">
                    <tr>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: #374151;">Name</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: #374151;">Email</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: #374151;">Role</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600; color: #374151;">Status</th>
                        <th style="padding: 1rem 1.5rem; text-align: right; font-weight: 600; color: #374151;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 1rem 1.5rem; font-weight: 500; color: #1f2937;">{{ $user->name }}</td>
                            <td style="padding: 1rem 1.5rem; color: #4b5563;">{{ $user->email }}</td>
                            <td style="padding: 1rem 1.5rem; color: #4b5563;">{{ ucfirst($user->role) }}</td>
                            <td style="padding: 1rem 1.5rem;">
                                @php
                                    $statusColors = [
                                        'active' => ['bg' => '#d1fae5', 'text' => '#065f46'],
                                        'inactive' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                                        'default' => ['bg' => '#f3f4f6', 'text' => '#374151'],
                                    ];
                                    $status = $statusColors[$user->status] ?? $statusColors['default'];
                                @endphp
                                <span
                                    style="
                                display: inline-block;
                                padding: 0.25rem 0.75rem;
                                font-size: 0.75rem;
                                font-weight: 600;
                                border-radius: 9999px;
                                background-color: {{ $status['bg'] }};
                                color: {{ $status['text'] }};
                            ">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>
                            <td style="padding: 1rem 1.5rem; text-align: right;">
                                <div class="dropdown-container" style="position: relative; display: inline-block; text-align: left;">
                                    <button type="button" onclick="toggleDropdown({{ $user->id }}, event)"
                                        style="color:#4b5563; background:none; border:none; cursor:pointer;">
                                        <svg style="width: 1.25rem; height: 1.25rem;" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M6 10a2 2 0 114 0 2 2 0 01-4 0zm4-6a2 2 0 114 0 2 2 0 01-4 0zm0 12a2 2 0 114 0 2 2 0 01-4 0z" />
                                        </svg>
                                    </button>
                                    <div id="dropdown-{{ $user->id }}"
                                        style="display: none; position: absolute; right: 0; margin-top: 0.5rem; width: 11rem; background:#fff; border-radius:0.375rem; box-shadow:0 1px 3px rgba(0,0,0,0.1); border:1px solid #e5e7eb; z-index:50;">
                                        <a href="{{ route('users.edit', $user) }}"
                                            style="display:block; padding:0.5rem 1rem; font-size:0.875rem; color:#4b5563; text-decoration:none;"
                                            onmouseover="this.style.backgroundColor='#f3f4f6'"
                                            onmouseout="this.style.backgroundColor='transparent'">Edit</a>
                                        
                                        @if($user->status === 'active')
                                            <form method="POST" action="{{ route('users.toggle-status', $user) }}" style="margin: 0;" onsubmit="return confirm('Are you sure you want to deactivate this user?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    style="width:100%; text-align:left; padding:0.5rem 1rem; font-size:0.875rem; color:#92400e; background:none; border:none; cursor:pointer;"
                                                    onmouseover="this.style.backgroundColor='#f3f4f6'"
                                                    onmouseout="this.style.backgroundColor='transparent'">
                                                    Deactivate
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('users.toggle-status', $user) }}" style="margin: 0;" onsubmit="return confirm('Are you sure you want to activate this user?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    style="width:100%; text-align:left; padding:0.5rem 1rem; font-size:0.875rem; color:#166534; background:none; border:none; cursor:pointer;"
                                                    onmouseover="this.style.backgroundColor='#f3f4f6'"
                                                    onmouseout="this.style.backgroundColor='transparent'">
                                                    Activate
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form method="POST" action="{{ route('users.destroy', $user) }}" style="margin: 0;" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                style="width:100%; text-align:left; padding:0.5rem 1rem; font-size:0.875rem; color:#dc2626; background:none; border:none; cursor:pointer;"
                                                onmouseover="this.style.backgroundColor='#f3f4f6'"
                                                onmouseout="this.style.backgroundColor='transparent'">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding:1.5rem; text-align:center; color:#6b7280;">
                                No staff members found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div style="margin-top: 1.5rem;">
            {{ $users->links() }}
        </div>
    </div>

    <!-- JS for dropdown -->
    <script>
        function toggleDropdown(id, event) {
            event.preventDefault(); // prevent default action
            event.stopPropagation(); // prevent the click from bubbling

            // Close all other dropdowns
            document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
                if (el.id !== 'dropdown-' + id) el.style.display = 'none';
            });

            // Toggle current dropdown
            const el = document.getElementById('dropdown-' + id);
            el.style.display = (el.style.display === 'block') ? 'none' : 'block';
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            // Check if the click is inside a dropdown
            if (!e.target.closest('.dropdown-container') && !e.target.closest('[id^="dropdown-"]')) {
                document.querySelectorAll('[id^="dropdown-"]').forEach(el => el.style.display = 'none');
            }
        });
    </script>
@endsection