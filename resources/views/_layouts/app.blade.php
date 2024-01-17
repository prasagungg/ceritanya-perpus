<!DOCTYPE html>
<html lang="en">
<head>
  @include('_includes.head')
</head>
<body class="bg-gray-100 font-family-karla flex">
    @include('_partials.sidebar')
    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        @include('_partials.header')

        <div class="w-full overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
              @yield('content')
            </main>
            
            @include('_partials.footer')
        </div>
        
    </div>

  @include('_includes.foot')
</body>
</html>
