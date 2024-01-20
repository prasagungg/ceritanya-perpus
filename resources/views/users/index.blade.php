@extends('_layouts.app')

@section('content')
<div class="flex items-center content-center pb-6 justify-between">
    <h1 class="text-3xl text-black">Users</h1>
    <a href="{{ route('users.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded">Create</a>
</div>

<div class="w-full">
    <!-- check user count exist or not -->
    @if ($users->count() > 0)
    <div class="bg-white overflow-auto p-5">
        <table class="min-w-full bg-white">
            <caption>User Information Table</caption>
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">NIM</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Name</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Email</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Contact</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Role</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($users as $user)
                <tr>
                    <td class="text-left py-3 px-4">{{ $user->nim }}</td>
                    <td class="text-left py-3 px-4">{{ $user->name }}</td>
                    <td class="text-left py-3 px-4">
                        <a class="hover:text-blue-500" href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                    </td>
                    <td class="text-left py-3 px-4">
                        <a class="hover:text-blue-500" href="tel:{{ $user->contact }}">{{ $user->contact }}</a>
                    </td>
                    <td class="w-1/3 text-left py-3 px-4">{{ $user->role }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- pagination -->
        {{ $users->links() }}
    </div>
    @else
        <p>No users found.</p>
    @endif
</div>

@endsection
