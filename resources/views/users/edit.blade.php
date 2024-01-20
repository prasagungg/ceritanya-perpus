@extends('_layouts.app')

@section('content')
<div class="flex items-center content-center pb-6 justify-between">
    <h1 class="text-3xl text-black">Edit User</h1>
    <a href="{{ route('users.index') }}" class="bg-blue-500 text-white py-2 px-4 rounded">Back</a>
</div>

<div class="w-full">
    <div class="bg-white overflow-auto">
        <form action="{{ route('users.update', $user->id) }}" method="POST" class="p-5">
            @csrf
            @method('PUT') <!-- Add this line to override the HTTP method for update -->

            <div class="mb-4">
                <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Role*</label>
                <select name="role" id="role" class="border rounded w-full py-2 px-3" required>
                    @foreach($user_roles as $roleKey => $roleName)
                    <option value="{{ $roleKey }}" {{ old('role', $user->role) == $roleKey ? 'selected' : '' }}>
                        {{ $roleName }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name*</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $user->name) }}"
                    class="border rounded w-full py-2 px-3"
                    required
                >
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email', $user->email) }}"
                    class="border rounded w-full py-2 px-3">
            </div>

            <div class="mb-4">
                <label for="nim" class="block text-gray-700 text-sm font-bold mb-2">NIM</label>
                <input
                    type="number"
                    name="nim"
                    id="nim"
                    value="{{ old('nim', $user->nim) }}"
                    class="border rounded w-full py-2 px-3">
            </div>

            <div class="mb-4">
                <label for="contact" class="block text-gray-700 text-sm font-bold mb-2">Contact*</label>
                <input
                    type="number"
                    name="contact"
                    id="contact"
                    value="{{ old('contact', $user->contact) }}"
                    class="border rounded w-full py-2 px-3"
                    required
                >
            </div>

            <div class="mt-4">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Update User</button>
            </div>
        </form>
    </div>
</div>

@endsection
