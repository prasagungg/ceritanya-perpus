@extends('_layouts.app')

@section('content')
<h1 class="text-3xl text-black pb-6">Dashboard</h1>

<div>
    Total peminjam : {{ $total_user }}
</div>

<div>
    Total Buku yang tersedia : {{ $total_book_active }}
</div>

<div>
    Total Buku yang dipinjam : {{ $total_book_inactive }}
</div>

<div class="flex flex-wrap gap-5">
    <div class="mt-12">
        <p class="text-xl pb-3 flex items-center">
            <i class="fas fa-list mr-3"></i> Top Mahasiswa ITBS yang sering pinjam
        </p>

        <!-- check top_five_mahasiswa_itbs_often_borrow count exist or not -->
        @if ($top_five_mahasiswa_itbs_often_borrow->count() > 0)
        <table class="bg-white">
            <caption></caption>
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Nama</th>
                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Total Buku yang di pinjam</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($top_five_mahasiswa_itbs_often_borrow as $user)
                <tr>
                    <td class="text-left py-3 px-4">{{ $user->name }}</td>
                    <td class="text-left py-3 px-4">{{ $user->borrows_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    <div class="mt-12">
        <p class="text-xl pb-3 flex items-center">
            <i class="fas fa-list mr-3"></i> Top Mahasiswa Luar yang sering pinjam
        </p>

        <!-- check top_five_mahasiswa_luar_often_borrow count exist or not -->
        @if ($top_five_mahasiswa_luar_often_borrow->count() > 0)
        <table class="bg-white">
            <caption></caption>
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Nama</th>
                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Total Buku yang di pinjam</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($top_five_mahasiswa_luar_often_borrow as $user)
                <tr>
                    <td class="text-left py-3 px-4">{{ $user->name }}</td>
                    <td class="text-left py-3 px-4">{{ $user->borrows_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    <div class="mt-12">
        <p class="text-xl pb-3 flex items-center">
            <i class="fas fa-list mr-3"></i> Top Masyarakat Umum yang sering pinjam
        </p>

        <!-- check top_five_masyarakat_umum_often_borrow count exist or not -->
        @if ($top_five_masyarakat_umum_often_borrow->count() > 0)
        <table class="bg-white">
            <caption></caption>
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Nama</th>
                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Total Buku yang di pinjam</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($top_five_masyarakat_umum_often_borrow as $user)
                <tr>
                    <td class="text-left py-3 px-4">{{ $user->name }}</td>
                    <td class="text-left py-3 px-4">{{ $user->borrows_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    <div class="mt-12">
        <p class="text-xl pb-3 flex items-center">
            <i class="fas fa-list mr-3"></i> Frekuensi Peminjaman Buku berdasarkan Role
        </p>

        <!-- check user_group_by_role count exist or not -->
        @if ($user_group_by_role->count() > 0)
        <table class="bg-white">
            <caption></caption>
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Role</th>
                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Total</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($user_group_by_role as $role_borrow)
                <tr>
                    <td class="text-left py-3 px-4">{{ $role_borrow->role }}</td>
                    <td class="text-left py-3 px-4">{{ $role_borrow->borrows_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    <div class="mt-12">
        <p class="text-xl pb-3 flex items-center">
            <i class="fas fa-list mr-3"></i> Frekuensi Peminjaman Buku berdasarkan Tanggal Pinjam
        </p>

        <!-- check transaction_borrow_group_by_borrow_start count exist or not -->
        @if ($transaction_borrow_group_by_borrow_start->count() > 0)
        <table class="bg-white">
            <caption></caption>
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Tanggal Pinjam</th>
                    <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Total</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($transaction_borrow_group_by_borrow_start as $borrow_start_trx)
                <tr>
                    <td class="text-left py-3 px-4">{{ $borrow_start_trx->borrow_date }}</td>
                    <td class="text-left py-3 px-4">{{ $borrow_start_trx->borrows_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>


@endsection
