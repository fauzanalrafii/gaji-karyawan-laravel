<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Z.Corporate</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen flex flex-col justify-center items-center bg-gradient-to-b from-green-400 to-green-100 font-sans">

    <div class="flex flex-col items-center mb-4">
        <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-20 mb-3">
        <h1 class="text-3xl font-bold text-green-800">Welcome</h1>
    </div>

    <form method="POST" action="{{ route('login.post') }}" class="w-80 bg-transparent">
        @csrf @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative mb-4 text-center text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
        <input type="email" name="email"
               value="{{ old('email') }}" 
               class="w-full p-2 rounded-full border border-green-300 mb-4 focus:ring focus:ring-green-200 outline-none transition"
               placeholder="Masukkan email anda" required autofocus>

        <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
        <input type="password" name="password"
               class="w-full p-2 rounded-full border border-green-300 mb-2 focus:ring focus:ring-green-200 outline-none transition"
               placeholder="********" required>

        <div class="flex items-center gap-2 mb-4">
            <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
            <label for="remember" class="text-sm text-gray-700">Ingat saya</label>
        </div>

        <button type="submit"
                class="w-full bg-green-600 text-white py-2 rounded-full hover:bg-green-700 transition font-semibold shadow-md">
            Masuk
        </button>
    </form>

    <footer class="absolute bottom-5 text-sm text-gray-700">
        © 2025 Intern. All rights reserved.
    </footer>

</body>
</html>