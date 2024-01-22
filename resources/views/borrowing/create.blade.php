@extends('_layouts.app')

@section('content')
<div class="flex items-center content-center pb-6 justify-between">
    <h1 class="text-3xl text-black">Peminjaman</h1>
    <a href="{{ route('borrow') }}" class="bg-blue-500 text-white py-2 px-4 rounded">Back</a>
</div>

<div class="w-full">
    <div class="bg-white overflow-auto">
        <form action="{{ route('borrowCreateData') }}" method="POST" class="p-5">
            @csrf
            <div class="mb-4">
                <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Nama Peminjam*</label>
                <select name="user_id" id="role" class="border rounded w-full py-2 px-3" required>
                    @foreach($user as $roleKey => $user)
                    <option value="{{ $user->id }}" {{ old('role') == $roleKey ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Buku*</label>
                <select name="book_id" id="roleBook" class="border rounded w-full py-2 px-3" required>
                    @foreach($books as $roleBook => $book)
                    <option value="{{ $book->id }}" {{ old('role') == $roleBook ? 'selected' : '' }}>
                        {{ $book->title }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Peminjam*</label>
                <input type="date" name="borrow_start" placeholder="YYYY-MM-DD">
            </div>

            <div class="mb-4">
                <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Pengembalian*</label>
                <input type="date" name="borrow_end" placeholder="YYYY-MM-DD">
            </div>

            <div class="mt-4">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Menambahkan Peminjam</button>
            </div>

        </form>
    </div>
</div>

@endsection
