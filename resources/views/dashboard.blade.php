<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistem Penggajian Karyawan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col bg-gradient-to-b from-green-400 to-green-100 font-sans">

  <header class="bg-white shadow-md flex justify-between items-center px-4 py-2 border-b border-gray-200">
    <h1 class="text-2xl font-bold text-gray-800 px-4 md:px-12">
      <span class="text-gray-700">Z.</span><span class="text-green-600">Corporate</span>
    </h1>
    <div class="flex items-center gap-4 mr-2">
      <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-32 h-auto"> 
      
      <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="flex items-center gap-2 text-black px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-100">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
              </svg>
              Keluar
          </button>
      </form>
    </div>
  </header>

   <h2 class="text-3xl font-bold text-center md:text-center text-white drop-shadow-md tracking-wide mt-8">
      SISTEM PENGGAJIAN KARYAWAN
    </h2>

    <main class="px-6 md:px-24 mt-8">
      <div class="mx-auto max-w-7xl grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
        
        <div class="max-w-xl">
          <p class="text-lg text-black">
            <span class="text-red-600 font-semibold">Welcome,</span>
            <a href="#" class="text-black-100 font-semibold underline">
                {{ Auth::user()->name ?? 'Admin' }} ! 
            </a>
          </p>

          <p class="mt-3 text-gray-800 leading-relaxed">
            Pantau dan kelola data karyawan serta penggajian mereka dengan mudah. Melalui sistem ini,
            Anda dapat menambahkan, memperbarui, dan menghapus data karyawan, serta mencatat rincian
            penggajian setiap periode dengan akurat.
          </p>

          <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ route('karyawan.index') }}"
               class="bg-green-600 text-white px-5 py-2 rounded-full text-sm font-semibold hover:bg-green-700 transition">
              Data Karyawan
            </a>
            <a href="{{ route('gaji.index') }}"
               class="bg-green-600 text-white px-5 py-2 rounded-full text-sm font-semibold hover:bg-green-700 transition">
              Gaji Karyawan
            </a>
          </div>
        </div>

        <div class="flex justify-center md:justify-end">
            <img src="{{ asset('assets/dashboard-illustration.png') }}"
               alt="Gambar Dashboard"
               class="w-72 md:w-[450px] h-auto object-contain drop-shadow-lg">
        </div>

      </div>
    </main>

  <footer class="mt-auto text-center text-gray-700 text-sm py-4">
    © 2025 Intern. All rights reserved.
  </footer>

</body>
</html>
