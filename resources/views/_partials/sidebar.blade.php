<aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
  <div class="p-6">
      <a href="{{ url('/') }}" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Ceritanya Perpus</a>
  </div>
  <nav class="text-white text-base font-semibold pt-3">
      <a
        href="{{ url('/') }}"
        class="flex items-center text-white py-4 pl-6 nav-item
            {{ url()->current() == url('/') ? 'active-nav-link' : 'opacity-75 hover:opacity-100' }}
        "
       >
          <i class="fas fa-tachometer-alt mr-3"></i>
          Dashboard
      </a>
      <a href="{{ route('books.index') }}" class="@if(request()->routeIs('books.*')) active-nav-link @else opacity-75 hover:opacity-100 @endif flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
          <i class="fas fa-table mr-3"></i>
          Buku
      </a>
      <a
        href="{{ route('users.index') }}"
        class="flex items-center text-white py-4 pl-6 nav-item
            {{ request()->routeIs('users.index') ? 'active-nav-link' : 'opacity-75 hover:opacity-100' }}
        "
       >
          <i class="fas fa-align-left mr-3"></i>
          Users
      </a>
      <a href="tabs.html" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
          <i class="fas fa-tablet-alt mr-3"></i>
          Peminjaman
      </a>
  </nav>
</aside>
