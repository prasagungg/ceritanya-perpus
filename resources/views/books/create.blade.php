@extends('_layouts.app')

@section('content')
<div class="flex items-center content-center pb-6 justify-between">
    <h1 class="text-3xl text-black">Tambah Buku</h1>
    <a href="{{ route('books.index') }}" class="bg-blue-500 text-white py-2 px-4 rounded">Kembali</a>
</div>

<div class="w-full">
    <div class="bg-white overflow-auto">
      <form action="{{ route('books.store') }}" method="POST" class="p-5">
          @csrf

          <div class="mb-4">
              <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Judul*</label>
              <input
                  type="text"
                  name="title"
                  id="title"
                  value="{{ old('title') }}"
                  class="border rounded w-full py-2 px-3"
                  required
              >
          </div>

          <div class="mb-4">
              <label for="no_isbn" class="block text-gray-700 text-sm font-bold mb-2">No ISBN*</label>
              <input
                  type="text"
                  name="no_isbn"
                  id="no_isbn"
                  value="{{ old('no_isbn') }}"
                  class="border rounded w-full py-2 px-3">
          </div>

          <div class="mb-4">
              <label for="no_catalog" class="block text-gray-700 text-sm font-bold mb-2">No Katalog*</label>
              <input
                  type="text"
                  name="no_catalog"
                  id="no_catalog"
                  value="{{ old('no_catalog') }}"
                  class="border rounded w-full py-2 px-3">
          </div>

          <div class="mt-4">
              <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Tambah</button>
          </div>
      </form>
    </div>
</div>

@endsection
