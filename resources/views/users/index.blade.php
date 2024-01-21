@extends('_layouts.app')

@section('content')
<div class="flex items-center content-center pb-6 justify-between">
    <h1 class="text-3xl text-black">{{ ucwords($page_title) }}</h1>
    <a href="{{ route('users.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded">Buat</a>
</div>

<div class="w-full">
    <!-- filter role -->
    <form action="{{ route('users.index') }}" method="GET" class="py-5">
        <label for="role">Pencarian :</label>
        <select name="role" id="role">
            <option value="">Semua Roles</option>
            @foreach($user_roles as $roleKey => $roleName)
                <option value="{{ $roleKey }}" {{ request('role') == $roleKey ? 'selected' : '' }}>
                    {{ $roleName }}
                </option>
            @endforeach
        </select>
        <input
            type="text"
            name="name"
            id="name"
            value="{{ old('name', request('name')) }}"
            class="border rounded py-2 px-3"
            placeholder="nama"
        >
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Cari</button>
        <a href="{{ route('users.index') }}" class="bg-blue-500 text-white py-2 px-4 rounded">Hapus Pencarian</a>
    </form>

    <!-- check user count exist or not -->
    @if ($users->count() > 0)
    <div class="bg-white overflow-auto p-5">
        <table class="min-w-full bg-white">
            <caption></caption>
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">NIM</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">NAMA</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">EMAIL</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">KONTAK</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">ROLE</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">AKSI</th>
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
                    <td class="w-1/3 text-left py-3 px-4">
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
                    <td class="flex gap-5 items-center py-3">
                        <a
                            class="bg:black hover:bg:red-700 delete-btn cursor-pointer"
                            data-id="{{ $user->id }}"
                            data-name="{{ $user->name }}"
                        >
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </a>
                        <a
                            class="bg:black hover:bg:red-700 cursor-pointer"
                            href="{{ route('users.edit', $user->id) }}"
                        >
                            <i class="fa fa-edit" aria-hidden="true"></i>
                        </a>
                        <a
                            class="bg:black hover:bg:red-700 cursor-pointer"
                            href="{{ route('users.show', $user->id) }}"
                        >
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- pagination -->
        {{ $users->appends(request()->query())->links() }}
    </div>
    @else
        <p>No {{ $page_title }} found.</p>
    @endif
</div>

@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                const userId = button.getAttribute('data-id');
                const userName = button.getAttribute('data-name');

                Swal.fire({
                    title: 'Apakah yakin?',
                    text: `Kamu yakin ingin menghapus user ${userName}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                         // Dynamically create and submit the form
                         const form = document.createElement('form');
                        form.action = `{{ route('users.destroy', ':userId') }}`.replace(':userId', userId);
                        form.method = 'POST';

                        // Append CSRF token
                        const csrfTokenInput = document.createElement('input');
                        csrfTokenInput.type = 'hidden';
                        csrfTokenInput.name = '_token';
                        csrfTokenInput.value = '{{ csrf_token() }}';
                        form.appendChild(csrfTokenInput);

                        // Append method override for DELETE
                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';
                        form.appendChild(methodInput);

                        // Append submit button (optional)
                        const submitButton = document.createElement('button');
                        submitButton.type = 'submit';
                        submitButton.className = 'btn btn-danger btn-sm';
                        submitButton.innerText = 'Delete';
                        form.appendChild(submitButton);

                        // Append the form to the body
                        document.body.appendChild(form);

                        // Submit the form
                        form.submit();
                    }
                });
            });
        });
    });
</script>

