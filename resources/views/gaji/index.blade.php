<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Data Gaji Karyawan</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
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
        <button type="submit" class="flex items-center gap-2 text-black px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-100">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
            </svg>
            Keluar
        </button>
    </form>
</header>

<main class="flex-1 px-4 md:px-10 py-10">
    <div class="w-full max-w-6xl mx-auto">

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mb-6">
            <a href="{{ route('dashboard') }}" class="w-full sm:w-auto text-center bg-black text-white px-5 py-2 font-semibold hover:bg-gray-800 rounded-sm">Kembali</a>
            <a href="{{ route('karyawan.index') }}" class="w-full sm:w-auto text-center bg-white text-green-600 border border-green-600 px-5 py-2 font-semibold hover:bg-green-50 rounded-sm">Data Karyawan</a>
        </div>

        <div class="bg-white shadow-lg w-full p-6 rounded-md">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
                <h2 class="text-lg font-bold tracking-widest text-gray-800 border-b pb-2">KELOLA GAJI KARYAWAN</h2>
                <button onclick="openModalTambah()" class="bg-green-600 hover:bg-green-700 text-white font-medium px-5 py-2 rounded-full shadow">Add Gaji</button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse text-left text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 border-b font-bold">
                            <th class="py-2 px-2">Nama</th>
                            <th class="py-2 px-2">No. Telp</th>
                            <th class="py-2 px-2">Periode</th>
                            <th class="py-2 px-2">Gaji Pokok</th>
                            <th class="py-2 px-2">Tunjangan</th>
                            <th class="py-2 px-2">Potongan</th>
                            <th class="py-2 px-2">Total Gaji</th>
                            <th class="py-2 px-2 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gaji as $d)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-2 font-semibold">{{ $d->karyawan->nama ?? 'Dihapus' }}</td>
                            <td class="py-2 px-2">{{ $d->karyawan->no_telp ?? '-' }}</td>
                            <td class="py-2 px-2">{{ $d->bulan }} {{ $d->tahun }}</td>
                            <td class="py-2 px-2">Rp {{ number_format($d->gaji_pokok, 0, ',', '.') }}</td>
                            <td class="py-2 px-2">Rp {{ number_format($d->tunjangan, 0, ',', '.') }}</td>
                            <td class="py-2 px-2 text-red-500">Rp {{ number_format($d->potongan, 0, ',', '.') }}</td>
                            <td class="py-2 px-2 font-bold text-green-600">Rp {{ number_format($d->total_gaji, 0, ',', '.') }}</td>
                            <td class="py-2 px-2 text-center flex justify-center gap-2">
                                <button onclick="openModalEdit({{ $d }})" class="text-green-600 hover:text-green-800">
                                    <i class="ri-edit-2-fill text-xl"></i>
                                </button>
                                <form action="{{ route('gaji.destroy', $d->id_gaji) }}" method="POST" onsubmit="return confirm('Yakin hapus gaji ini?');">
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

<div id="modalTambah" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white w-full max-w-md rounded-lg shadow-lg overflow-hidden">
    <div class="bg-green-600 text-white text-center py-3 text-lg font-semibold">Tambah Data Gaji</div>
    <form action="{{ route('gaji.store') }}" method="POST" class="p-6 space-y-4">
      @csrf
      <div>
        <label class="block font-semibold mb-1">Nama Karyawan</label>
        <select id="id_karyawan" name="id_karyawan" class="border border-gray-400 rounded w-full px-3 py-2" required onchange="isiOtomatisTambah()">
          <option value="">-- Pilih Karyawan --</option>
          @foreach($karyawanList as $k)
            <option value="{{ $k->id }}" data-no="{{ $k->no_telp }}">{{ $k->nama }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block font-semibold mb-1">No. Telepon</label>
        <input id="no_telp_tambah" type="text" class="border border-gray-400 rounded w-full px-3 py-2 bg-gray-100" readonly placeholder="Otomatis terisi">
      </div>
      
      <div class="flex gap-2">
        <div class="flex-1">
          <label class="block font-semibold mb-1">Bulan</label>
          <select name="bulan" class="border border-gray-400 rounded w-full px-3 py-2">
            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bulan)
                <option value="{{ $bulan }}">{{ $bulan }}</option>
            @endforeach
          </select>
        </div>
        <div class="flex-1">
          <label class="block font-semibold mb-1">Tahun</label>
          <input name="tahun" type="number" value="{{ date('Y') }}" class="border border-gray-400 rounded w-full px-3 py-2" required>
        </div>
      </div>

      <div><label class="block font-semibold mb-1">Gaji Pokok</label><input name="gaji_pokok" type="number" class="border border-gray-400 rounded w-full px-3 py-2" required></div>
      <div><label class="block font-semibold mb-1">Tunjangan</label><input name="tunjangan" type="number" class="border border-gray-400 rounded w-full px-3 py-2" required></div>
      <div><label class="block font-semibold mb-1">Potongan</label><input name="potongan" type="number" class="border border-gray-400 rounded w-full px-3 py-2" required></div>

      <div class="flex justify-end space-x-3 mt-4">
        <button type="button" onclick="closeModalTambah()" class="bg-black text-white px-4 py-2 rounded-full">Kembali</button>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-full">Simpan</button>
      </div>
    </form>
  </div>
</div>

<div id="modalEdit" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-white w-full max-w-md rounded-lg shadow-lg overflow-hidden">
    <div class="bg-green-600 text-white text-center py-3 text-lg font-semibold">Edit Data Gaji</div>
    <form id="formEdit" method="POST" class="p-6 space-y-4">
      @csrf
      @method('PUT')

      <input type="hidden" name="id_karyawan" id="edit_input_id_karyawan">

      <div>
        <label class="block font-semibold mb-1">Nama Karyawan</label>
        <input id="edit_nama_karyawan" type="text" class="border border-gray-400 rounded w-full px-3 py-2 bg-gray-100" readonly>
      </div>

      <div class="flex gap-2">
        <div class="flex-1">
            <label class="block font-semibold mb-1">Bulan</label>
            <select id="edit_bulan" name="bulan" class="border border-gray-400 rounded w-full px-3 py-2">
              @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bulan)
                  <option value="{{ $bulan }}">{{ $bulan }}</option>
              @endforeach
            </select>
        </div>
        <div class="flex-1">
            <label class="block font-semibold mb-1">Tahun</label>
            <input id="edit_tahun" name="tahun" type="number" class="border border-gray-400 rounded w-full px-3 py-2" required>
        </div>
      </div>

      <div><label class="block font-semibold mb-1">Gaji Pokok</label><input id="edit_gaji_pokok" name="gaji_pokok" type="number" class="border border-gray-400 rounded w-full px-3 py-2" required></div>
      <div><label class="block font-semibold mb-1">Tunjangan</label><input id="edit_tunjangan" name="tunjangan" type="number" class="border border-gray-400 rounded w-full px-3 py-2" required></div>
      <div><label class="block font-semibold mb-1">Potongan</label><input id="edit_potongan" name="potongan" type="number" class="border border-gray-400 rounded w-full px-3 py-2" required></div>

      <div class="flex justify-end space-x-3 mt-4">
        <button type="button" onclick="closeModalEdit()" class="bg-black text-white px-4 py-2 rounded-full">Kembali</button>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-full">Update</button>
      </div>
    </form>
  </div>
</div>

<script>
// Logic Auto-fill No Telp
function isiOtomatisTambah(){
  const select = document.getElementById('id_karyawan');
  // Ambil data-no dari option yang dipilih
  const noTelp = select.options[select.selectedIndex].getAttribute('data-no');
  document.getElementById('no_telp_tambah').value = noTelp ? noTelp : '';
}

function openModalTambah(){ document.getElementById('modalTambah').classList.remove('hidden'); }
function closeModalTambah(){ document.getElementById('modalTambah').classList.add('hidden'); }

// Logic Buka Modal Edit
function openModalEdit(data){
    document.getElementById('modalEdit').classList.remove('hidden');
    
    // Set URL Action Form
    document.getElementById('formEdit').action = '/gaji/' + data.id_gaji;

    document.getElementById('edit_input_id_karyawan').value = data.id_karyawan;

    // Isi Form
    // Perhatikan: data.karyawan bisa null jika karyawan dihapus
    document.getElementById('edit_nama_karyawan').value = data.karyawan ? data.karyawan.nama : 'Karyawan Dihapus';
    document.getElementById('edit_bulan').value = data.bulan;
    document.getElementById('edit_tahun').value = data.tahun;
    document.getElementById('edit_gaji_pokok').value = data.gaji_pokok;
    document.getElementById('edit_tunjangan').value = data.tunjangan;
    document.getElementById('edit_potongan').value = data.potongan;
}

function closeModalEdit(){ document.getElementById('modalEdit').classList.add('hidden'); }
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
