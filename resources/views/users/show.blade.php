@extends('_layouts.app')

@section('content')
<div class="flex items-center content-center pb-6 justify-between">
    <h1 class="text-3xl text-black">Detail {{ ucwords($page_title) }}</h1>
    <a href="{{ route('users.index') }}" class="bg-blue-500 text-white py-2 px-4 rounded">Back</a>
</div>

<div class="w-full">
    <div class="bg-white overflow-auto">
        <table>
            <caption></caption>
            <thead>
                <tr>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-left py-3 px-4 uppercase font-semibold text-sm">Role</td>
                    <td class="text-left py-3 px-4 uppercase font-semibold text-sm">:</td>
                    <td class="text-left py-3 px-4 uppercase font-semibold text-sm">
                        @if($user->role == 'mahasiswa_itbs')
                        <span class="bg-green-100 text-green-800 text-xs font-medium me-2
                            px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                            Mahasiswa ITBS
                        </span>
                        @elseif($user->role == 'mahasiswa_luar')
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2
                            px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">
                            Mahasiswa Luar
                        </span>
                        @elseif($user->role == 'masyarakat_umum')
                        <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2
                            px-2.5 py-0.5 rounded dark:bg-gray-900 dark:text-gray-300">
                            Masyarakat Umum
                        </span>
                        @else
                        <span>{{ $user->role }}</span>
                        @endif
                    </td>
                </tr>
                @if($user->nim)
                <tr>
                    <td class="text-left py-3 px-4 uppercase font-semibold text-sm">NIM</td>
                    <td class="text-left py-3 px-4 uppercase font-semibold text-sm">:</td>
                    <td class="text-left py-3 px-4 uppercase font-semibold text-sm">{{ $user->nim }}</td>
                </tr>
                @endif
                <tr>
                    <td class="text-left py-3 px-4 uppercase font-semibold text-sm">Nama</td>
                    <td class="text-left py-3 px-4 uppercase font-semibold text-sm">:</td>
                    <td class="text-left py-3 px-4 uppercase font-semibold text-sm">{{ $user->name }}</td>
                </tr>
                <tr>
                    <td class="text-left py-3 px-4 uppercase font-semibold text-sm">Email</td>
                    <td class="text-left py-3 px-4 uppercase font-semibold text-sm">:</td>
                    <td class="text-left py-3 px-4 uppercase font-semibold text-sm">{{ $user->email }}</td>
                </tr>
                <tr>
                    <td class="text-left py-3 px-4 uppercase font-semibold text-sm">Kontak</td>
                    <td class="text-left py-3 px-4 uppercase font-semibold text-sm">:</td>
                    <td class="text-left py-3 px-4 uppercase font-semibold text-sm">{{ $user->contact }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- check trx_with_books count exist or not -->
    @if ($trx_with_books->count() > 0)
    <div class="bg-white overflow-auto p-5">
        <table class="min-w-full bg-white">
            <caption></caption>
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Judul</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Rentang Pinjam</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Tanggal Kembali</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Status</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($trx_with_books as $trx)
                <tr>
                    <td class="text-left py-3 px-4">{{ $trx->title }}</td>
                    <td class="text-left py-3 px-4">{{ $trx->borrow_start }} - {{ $trx->borrow_end }}</td>
                    <td class="text-left py-3 px-4">{{ $trx->return_on }}</td>
                    <td class="text-left py-3 px-4">
                        @if($trx->return_on)
                        <span class="bg-green-100 text-green-800 text-xs font-medium me-2
                            px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Dikembalikan</span>
                        @else
                        <span class="bg-red-100 text-red-800 text-xs font-medium me-2
                            px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Belum Dikembalikan</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- pagination -->
        {{ $trx_with_books->appends(request()->query())->links() }}
    </div>
    @else
        <p>No borrow {{ $page_title }} found.</p>
    @endif

</div>

@endsection
