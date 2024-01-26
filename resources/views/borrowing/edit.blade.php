@extends('_layouts.app')

@section('content')
<div class="flex items-center content-center pb-6 justify-between">
    <h1 class="text-3xl text-black">Edit Peminjaman</h1>
    <a href="{{ route('borrow') }}" class="bg-blue-500 text-white py-2 px-4 rounded">Kembali</a>
</div>

<div class="w-full">
    <div class="bg-white overflow-auto">
        <form action="{{ route('updateBorrow', $borrows->transaction_borrow_id) }}" method="POST" class="p-5">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Pengembalian*</label>
                <input type="date" name="return_on" placeholder="YYYY-MM-DD" value="{{ old('return_on', $borrows->return_on) }}" id="return_on">
            </div>

            <div class="mt-4">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Update</button>
            </div>
        </form>
    </div>
</div>

@endsection
