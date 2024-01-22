@extends('_layouts.app')

@section('content')
<div class="flex items-center content-center pb-6 justify-between">
    <h1 class="text-3xl text-black">Peminjaman</h1>
    <a href="{{ route('borrowCreate') }}" class="bg-blue-500 text-white py-2 px-4 rounded">Create</a>
</div>

<div class="w-full">
    <!-- filter role -->
    <form action="{{ route('filterBorrow') }}" method="GET" class="py-5">
        <div class="row">
            <div>Tanggal Peminjaman :</div>
            <div>
                <label>Dari tanggal :</label>
                <input type="date" name="borrow_start" placeholder="YYYY-MM-DD" class="form-control mr-4">

                <label>Sampai tanggal :</label>
                <input type="date" name="borrow_end" placeholder="YYYY-MM-DD" class="form-control mr-4">

                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Filter</button>
                <a href="{{ route('borrow') }}" class="bg-blue-500 text-white py-2 px-4 rounded">Clear Filter</a>
            </div>
        </div>
    </form>

    <div class="bg-white overflow-auto">
        <table class="text-left w-full border-collapse">
            <thead>
                <tr>
                    <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Nama Peminjam</th>
                    <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Buku</th>
                    <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Tanggal Peminjaman</th>
                    <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Tanggal Pengembalian</th>
                    <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Status Buku</th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrows as $borrow)
                    <tr class="hover:bg-grey-lighter">
                        <td class="text-left py-3 px-6">{{ $borrow->user->name }}</td>
                        <td class="text-left py-3 px-6">{{ $borrow->book->title}}</td>
                        <td class="text-left py-3 px-6">{{\Carbon\Carbon::parse($borrow->borrow_start)->isoFormat('D MMMM Y') }}</td>
                        <td class="text-left py-3 px-6">{{\Carbon\Carbon::parse($borrow->borrow_end)->isoFormat('D MMMM Y') }}</td>
                        <td class="py-4 px-6 border-b border-grey-light">
                            @if($borrow->return_on !== null)
                                <span class="text-left">Sudah di kembalikan pada : {{\Carbon\Carbon::parse($borrow->return_on)->isoFormat('D MMMM Y') }}</span>
                            @else
                            <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Sedang Dipinjam</span>
                            @endif
                        </td>
                        @if($borrow->return_on === null)
                            <td class="flex gap-5 items-center py-3">
                                <a class="bg:black hover:bg:red-700 cursor-pointer" href="{{ route('editBorrow', $borrow->transaction_borrow_id) }}">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                </a>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr class="hover:bg-grey-lighter" col="5">Tidak ada data Buku</tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection

