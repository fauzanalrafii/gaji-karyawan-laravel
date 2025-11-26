<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>

    {{-- Remix Icon --}}
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex flex-col bg-gradient-to-b from-green-400 to-green-100 font-sans">

    {{-- HEADER --}}
    <header class="bg-white shadow-md flex justify-between items-center px-4 py-2 border-b border-gray-200">
        <h1 class="text-2xl font-bold text-gray-800 px-4 md:px-12 cursor-default">
            <span class="text-gray-700">Z.</span><span class="text-green-600">Corporate</span>
        </h1>

        <div class="flex items-center gap-4 mr-2">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-20 h-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="cursor-pointer flex items-center gap-2 text-gray-600 hover:text-red-600 hover:bg-red-50 px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200 border border-transparent hover:border-red-100">
                    <i class="ri-logout-box-line text-lg"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </header>

    {{-- CONTENT --}}
    <main class="flex-1 px-4 md:px-10 py-10">
        <div class="w-full max-w-6xl mx-auto">
            @yield('content')
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="text-center text-gray-700 text-sm py-4">
        © 2025 Intern. All rights reserved.
    </footer>


    {{-- Popup Error & Success (Global) --}}
    <script>
        @if(session('success'))
            alert("{{ session('success') }}");
        @endif

        @if($errors->any())
            let pesanError = "GAGAL MENYIMPAN DATA:\n";
            @foreach ($errors->all() as $error)
                pesanError += "- {{ $error }}\n";
            @endforeach
            alert(pesanError);
        @endif
    </script>

    @yield('scripts')

</body>
</html>
