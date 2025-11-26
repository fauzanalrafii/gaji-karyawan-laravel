<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Data Karyawan</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-gradient-to-b from-green-400 to-green-100 font-sans">

<header class="bg-white shadow-md flex justify-between items-center px-4 py-2 border-b border-gray-200">
    <h1 class="text-2xl font-bold text-gray-800 px-4 md:px-12">
      <span class="text-gray-700">Z.</span><span class="text-green-600">Corporate</span>
    </h1>
    <div class="flex items-center gap-4 mr-2">
      <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="w-20 h-auto">
      
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="cursor-pointer flex items-center gap-2 text-gray-600 hover:text-red-600 hover:bg-red-50 px-4 py-2 rounded-full text-sm font-semibold transition-all duration-200 border border-transparent hover:border-red-100">
            <i class="ri-logout-box-line text-lg"></i>
            <span>Keluar</span>
        </button>
    </form>
</header>

<main class="flex-1 px-4 md:px-10 py-10">
  <div class="w-full max-w-6xl mx-auto">

    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mb-6">
      <a href="{{ route('dashboard') }}" class="w-full sm:w-auto text-center bg-black text-white px-5 py-2 font-semibold hover:bg-gray-800 transition rounded-sm">Kembali</a>
      <a href="{{ route('gaji.index') }}" class="w-full sm:w-auto text-center bg-white text-green-600 border border-green-600 px-5 py-2 font-semibold hover:bg-green-50 transition rounded-sm">Gaji Karyawan</a>
    </div>

    <div class="bg-white shadow-lg w-full p-8 rounded-md">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
        <h2 class="text-lg font-bold tracking-widest text-gray-800 border-b pb-2">KELOLA DATA KARYAWAN</h2>
        <button onclick="openModalTambah()" class="bg-green-600 text-white px-5 py-2 rounded-full font-semibold hover:bg-green-700 transition">Add Data</button>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full border-collapse text-left">
          <thead>
            <tr class="bg-gray-100 text-gray-700 border-b font-bold">
              <th class="py-3 px-4 font-semibold">No</th>
              <th class="py-3 px-4 font-semibold">Nama</th>
              <th class="py-3 px-4 font-semibold">Jabatan</th>
              <th class="py-3 px-4 font-semibold">Alamat</th>
              <th class="py-3 px-4 font-semibold">No Telp</th>
              <th class="py-3 px-4 text-center font-semibold">Action</th>
            </tr>
          </thead>
          <tbody class="text-gray-800">
            @foreach($karyawan as $index => $data)
            <tr class="border-b hover:bg-gray-50 transition">
                <td class="py-2 px-3 font-semibold">{{ $index + 1 }}</td>
                <td class="py-2 px-3">{{ $data->nama }}</td>
                <td class="py-2 px-3">{{ $data->jabatan }}</td>
                <td class="py-2 px-3">{{ $data->alamat }}</td>
                <td class="py-2 px-3">{{ $data->no_telp }}</td>
                <td class="py-2 px-3 text-center flex justify-center items-center gap-2">
                    <button onclick="editData({{ $data->id }}, '{{ $data->nama }}', '{{ $data->jabatan }}', '{{ $data->alamat }}', '{{ $data->no_telp }}')"
                        class="text-green-600 hover:text-green-800">
                        <i class="ri-edit-2-fill text-xl"></i>
                    </button>
                    
                    <form action="{{ route('karyawan.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini? Data gaji terkait juga akan terhapus.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            <i class="ri-delete-bin-5-fill text-xl"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<footer class="text-center text-gray-700 text-sm py-4">
    © 2025 Intern. All rights reserved.
</footer>

<div id="modalTambah" class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm" style="background-color: rgba(0, 0, 0, 0.2);">
  <div class="bg-white w-full max-w-md rounded-xl shadow-xl overflow-hidden">
    <div class="bg-green-600 text-white text-center py-3 text-lg font-semibold shadow-md">
      Tambah Data Karyawan
    </div>

    <form action="{{ route('karyawan.store') }}" method="POST" class="p-6 space-y-4 flex flex-col">
      @csrf
      
      <div>
        <label class="block font-semibold mb-1 text-black">Nama</label>
          <input type="text" name="nama" class="border border-green-400 rounded w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
      </div>
      <div>
        <label class="block font-semibold mb-1 text-black">Jabatan</label>
        <input type="text" name="jabatan" class="border border-green-400 rounded w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
      </div>
      <div>
        <label class="block font-semibold mb-1 text-black">Alamat</label>
        <input type="text" name="alamat" class="border border-green-400 rounded w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
      </div>
      <div>
        <label class="block font-semibold mb-1 text-black">No Telp</label>
        <input type="text" name="no_telp" class="border border-green-400 rounded w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="628..." required>
        <p class="text-xs text-gray-500 mt-1">*Awali dengan 628</p>
      </div>

      <div class="flex justify-end space-x-3 mt-2">
        <button type="button" onclick="closeModalTambah()" class="px-4 py-2 bg-black text-white border border-green-500 rounded-full font-semibold">Kembali</button>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-full">Simpan</button>
      </div>
    </form>
  </div>
</div>

<div id="modalEdit" class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm" style="background-color: rgba(0, 0, 0, 0.2);">
  <div class="bg-white w-full max-w-md rounded-xl shadow-xl overflow-hidden">
    <div class="bg-green-600 text-white text-center py-3 text-lg font-semibold shadow-md">
      Edit Data Karyawan
    </div>

    <form id="formEdit" method="POST" class="p-6 space-y-4 flex flex-col">
      @csrf
      @method('PUT')

      <div>
        <label class="block font-semibold mb-1 text-black">Nama</label>
        <input type="text" name="nama" id="edit_nama" class="border border-green-400 rounded w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
      </div>
      <div>
        <label class="block font-semibold mb-1 text-black">Jabatan</label>
        <input type="text" name="jabatan" id="edit_jabatan" class="border border-green-400 rounded w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
      </div>
      <div>
        <label class="block font-semibold mb-1 text-black">Alamat</label>
        <input type="text" name="alamat" id="edit_alamat" class="border border-green-400 rounded w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
      </div>
      <div>
        <label class="block font-semibold mb-1 text-black">No Telp</label>
        <input type="text" name="no_telp" id="edit_no_telp" class="border border-green-400 rounded w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
      </div>

      <div class="flex justify-end space-x-3 mt-2">
        <button type="button" onclick="closeModalEdit()" class="px-4 py-2 bg-black text-white border border-green-500 rounded-full font-semibold">Kembali</button>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-full">Update</button>
      </div>
    </form>
  </div>
</div>

<script>
// Logic Modal Tambah
function openModalTambah() { document.getElementById('modalTambah').classList.remove('hidden'); }
function closeModalTambah() { document.getElementById('modalTambah').classList.add('hidden'); }

// Logic Modal Edit
function editData(id, nama, jabatan, alamat, no_telp) {
    // 1. Isi inputan dengan data yang diklik
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_jabatan').value = jabatan;
    document.getElementById('edit_alamat').value = alamat;
    document.getElementById('edit_no_telp').value = no_telp;
    
    // 2. Ubah URL Action formnya secara dinamis
    let form = document.getElementById('formEdit');
    form.action = '/karyawan/' + id;
    
    // 3. Tampilkan modal
    document.getElementById('modalEdit').classList.remove('hidden');
}

function closeModalEdit() { document.getElementById('modalEdit').classList.add('hidden'); }
</script>

<script>
    // --- POPUP SUKSES (Kalau ada session success) ---
    @if(session('success'))
        alert("{{ session('success') }}");
    @endif

    // --- POPUP ERROR (Kalau ada validasi gagal) ---
    @if($errors->any())
        let pesanError = "GAGAL MENYIMPAN DATA:\n";
        
        @foreach ($errors->all() as $error)
            pesanError += "- {{ $error }}\n";
        @endforeach
        
        alert(pesanError);
    @endif
</script>

</body>
</html>
