@extends('_layouts.app')

@section('content')
<div class="flex items-center content-center pb-6 justify-between">
    <h1 class="text-3xl text-black">Buku</h1>
    <a href="{{ route('books.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded">Buat</a>
</div>

<div class="bg-white overflow-auto">
    <table class="text-left w-full border-collapse">
        <thead>
            <tr>
                <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Judul</th>
                <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">ISBN</th>
                <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Katalog</th>
                <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
            <tr class="hover:bg-grey-lighter">
                <td class="py-4 px-6 border-b border-grey-light">{{ $book->title }}</td>
                <td class="py-4 px-6 border-b border-grey-light">{{ $book->no_isbn }}</td>
                <td class="py-4 px-6 border-b border-grey-light">{{ $book->no_catalog }}</td>
                <td class="py-4 px-6 border-b border-grey-light">
                    @if($book->status == 'active')
                    <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">{{ $book->status }}</span>
                    @else
                    <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">{{ $book->status }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr class="hover:bg-grey-lighter" col="5">Data tidak ada</tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection