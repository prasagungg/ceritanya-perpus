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
                <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Aksi</th>
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
                    <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Tersedia</span>
                    @else
                    <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Tidak Tersedia</span>
                    @endif
                </td>
                <td class="flex gap-5 items-center py-3">
                    <a
                        class="bg:black hover:bg:red-700 delete-btn cursor-pointer"
                        data-id="{{ $book->id }}"
                        data-title="{{ $book->title }}"
                    >
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                    <a
                        class="bg:black hover:bg:red-700 cursor-pointer"
                        href="{{ route('books.edit', $book->id) }}"
                    >
                        <i class="fa fa-edit" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr class="hover:bg-grey-lighter" col="5">Data tidak ada</tr>
            @endforelse
        </tbody>
    </table>

    {{ $books->appends(request()->query())->links() }}
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                const bookId = button.getAttribute('data-id');
                const title = button.getAttribute('data-title');

                Swal.fire({
                    title: 'Apakah yakin?',
                    text: `Kamu yakin ingin menghapus buku ${title}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                         // Dynamically create and submit the form
                         const form = document.createElement('form');
                        form.action = `{{ route('books.destroy', ':bookId') }}`.replace(':bookId', bookId);
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