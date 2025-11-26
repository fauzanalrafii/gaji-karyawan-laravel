{{-- 1. Panggil File Induk --}}
@extends('layouts/app')

{{-- 2. Isi Judul Tab Browser --}}
@section('title', 'Kelola Gaji Karyawan')

{{-- 3. Isi Konten Utama --}}
@section('content')

    {{-- Navigasi Atas --}}
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mb-6">
        <a href="{{ route('dashboard') }}" class="w-full sm:w-auto text-center bg-black text-white px-5 py-2 font-semibold hover:bg-gray-800 rounded-sm transition">
            Kembali
        </a>
        <a href="{{ route('karyawan.index') }}" class="w-full sm:w-auto text-center bg-white text-green-600 border border-green-600 px-5 py-2 font-semibold hover:bg-green-50 rounded-sm transition">
            Data Karyawan
        </a>
    </div>

    {{-- Card Tabel --}}
    <div class="bg-white shadow-lg w-full p-6 rounded-md">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
            <h2 class="text-lg font-bold tracking-widest text-gray-800 border-b pb-2">KELOLA GAJI KARYAWAN</h2>
            <button onclick="openModalTambah()" class="cursor-pointer bg-green-600 hover:bg-green-700 text-white font-medium px-5 py-2 rounded-full shadow transition">
                Add Gaji
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse text-left text-sm">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 border-b font-bold">
                        <th class="py-2 px-2">Nama</th>
                        <th class="py-2 px-2">Periode</th>
                        <th class="py-2 px-2">Gaji Pokok</th>
                        <th class="py-2 px-2">Tunjangan</th>
                        <th class="py-2 px-2">Potongan</th>
                        <th class="py-2 px-2">Total Gaji</th>
                        <th class="py-2 px-2 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gaji as $d)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-2 px-2 font-semibold">{{ $d->karyawan->nama ?? 'Dihapus' }}</td>
                        <td class="py-2 px-2">{{ $d->bulan }} {{ $d->tahun }}</td>
                        <td class="py-2 px-2">Rp {{ number_format($d->gaji_pokok, 0, ',', '.') }}</td>
                        <td class="py-2 px-2">Rp {{ number_format($d->tunjangan, 0, ',', '.') }}</td>
                        <td class="py-2 px-2 text-red-500">Rp {{ number_format($d->potongan, 0, ',', '.') }}</td>
                        <td class="py-2 px-2 font-bold text-green-600">Rp {{ number_format($d->total_gaji, 0, ',', '.') }}</td>
                        <td class="py-2 px-2 text-center flex justify-center gap-2">
                            <button onclick="openModalEdit({{ $d }})" class="cursor-pointer text-green-600 hover:text-green-800">
                                <i class="ri-edit-2-fill text-xl"></i>
                            </button>
                            <form action="{{ route('gaji.destroy', $d->id_gaji) }}" method="POST" onsubmit="return confirm('Yakin hapus gaji ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="cursor-pointer text-red-600 hover:text-red-800">
                                    <i class="ri-delete-bin-5-fill text-xl"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-10 text-gray-500">Belum ada data gaji.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div id="modalTambah" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="background-color: rgba(0, 0, 0, 0.2); backdrop-filter: blur(4px);">
        <div class="bg-white w-full max-w-md rounded-lg shadow-lg overflow-hidden">
            <div class="bg-green-600 text-white text-center py-3 text-lg font-semibold">Tambah Data Gaji</div>
            <form action="{{ route('gaji.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block font-semibold mb-1">
                      Nama Karyawan
                    <select id="id_karyawan" name="id_karyawan" class="cursor-pointer border border-gray-400 rounded w-full hover:bg-gray-100 px-3 py-2" required onchange="isiOtomatisTambah()">
                        <option value="">-- Pilih Karyawan --</option>
                        @foreach($karyawanList as $k)
                            <option value="{{ $k->id }}" data-no="{{ $k->no_telp }}">{{ $k->nama }}</option>
                        @endforeach
                    </select>
                    </label>
                </div>
                <div>
                    <label class="block font-semibold mb-1">
                      No. Telepon
                    <input id="no_telp_tambah" type="text" class="border border-gray-400 rounded w-full px-3 py-2 bg-gray-200" readonly placeholder="Otomatis terisi">
                    </label>
                </div>
                
                <div class="flex gap-2">
                    <div class="flex-1">
                        <label class="block font-semibold mb-1">
                          Bulan
                        <select name="bulan" class="cursor-pointer border border-gray-400 rounded w-full hover:bg-gray-100 px-3 py-2">
                            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bulan)
                                <option value="{{ $bulan }}">{{ $bulan }}</option>
                            @endforeach
                        </select>
                        </label>
                    </div>
                    <div class="flex-1">
                        <label class="block font-semibold mb-1">
                          Tahun
                        <input name="tahun" type="number" value="{{ date('Y') }}" class="border border-gray-400 rounded w-full hover:bg-gray-100 px-3 py-2" required>
                        </label>
                    </div>
                </div>

                <div>
                  <label class="block font-semibold mb-1">
                  Gaji Pokok
                  <input name="gaji_pokok" type="number" class="border border-gray-400 rounded w-full hover:bg-gray-100 px-3 py-2" required>
                  </label>
                </div>
                
                <div>
                  <label class="block font-semibold mb-1">
                  Tunjangan
                  <input name="tunjangan" type="number" class="border border-gray-400 rounded w-full hover:bg-gray-100 px-3 py-2" required>
                  </label>
                </div>
                
                <div>
                  <label class="block font-semibold mb-1">
                  Potongan
                  <input name="potongan" type="number" class="border border-gray-400 rounded w-full hover:bg-gray-100 px-3 py-2" required>
                  </label>
                </div>

                <div class="flex justify-end space-x-3 mt-4">
                    <button type="button" onclick="closeModalTambah()" class="cursor-pointer px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" class="cursor-pointer bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 shadow-md transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div id="modalEdit" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="background-color: rgba(0, 0, 0, 0.2); backdrop-filter: blur(4px);">
        <div class="bg-white w-full max-w-md rounded-lg shadow-lg overflow-hidden">
            <div class="bg-green-600 text-white text-center py-3 text-lg font-semibold">Edit Data Gaji</div>
            <form id="formEdit" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_karyawan" id="edit_input_id_karyawan">

                <div>
                    <label class="block font-semibold mb-1">
                      Nama Karyawan
                    <input id="edit_nama_karyawan" type="text" class="border border-gray-400 rounded w-full px-3 py-2 bg-gray-200" readonly>
                    <p class="text-xs text-gray-400 mt-1">*Tidak bisa edit nama</p>
                    </label>
                </div>

                <div class="flex gap-2">
                    <div class="flex-1">
                        <label class="block font-semibold mb-1">
                          Bulan
                        <select id="edit_bulan" name="bulan" class="cursor-pointer border border-gray-400 rounded w-full hover:bg-gray-100 px-3 py-2">
                            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bulan)
                                <option value="{{ $bulan }}">{{ $bulan }}</option>
                            @endforeach
                        </select>
                        </label>
                    </div>
                    <div class="flex-1">
                        <label class="block font-semibold mb-1">
                          Tahun
                        <input id="edit_tahun" name="tahun" type="number" class="border border-gray-400 rounded w-full hover:bg-gray-100 px-3 py-2" required>
                        </label>
                    </div>
                </div>

                <div>
                  <label class="block font-semibold mb-1">
                  Gaji Pokok
                  <input id="edit_gaji_pokok" name="gaji_pokok" type="number" class="border border-gray-400 rounded w-full hover:bg-gray-100 px-3 py-2" required>
                  </label>
                </div>

                <div>
                  <label class="block font-semibold mb-1">
                    Tunjangan<
                    <input id="edit_tunjangan" name="tunjangan" type="number" class="border border-gray-400 rounded w-full hover:bg-gray-100 px-3 py-2" required>
                    </label>
                  </div>

                <div>
                  <label class="block font-semibold mb-1">
                    Potongan
                    <input id="edit_potongan" name="potongan" type="number" class="border border-gray-400 rounded w-full hover:bg-gray-100 px-3 py-2" required>
                    </label>
                  </div>

                <div class="flex justify-end space-x-3 mt-4">
                    <button type="button" onclick="closeModalEdit()" class="cursor-pointer px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition">Batal</button>
                    <button type="submit" class="cursor-pointer bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 shadow-md transition">Update</button>
                </div>
            </form>
        </div>
    </div>

@endsection

{{-- 4. Isi Script Khusus Halaman Ini --}}
@section('scripts')
<script>
    // Note: Script Alert SUKSES & ERROR sudah ada di layout.blade.php (Global),
    // Jadi di sini kita cuma butuh script logika Modal saja.

    function isiOtomatisTambah(){
        const select = document.getElementById('id_karyawan');
        const noTelp = select.options[select.selectedIndex].getAttribute('data-no');
        document.getElementById('no_telp_tambah').value = noTelp ? noTelp : '';
    }

    function openModalTambah(){ document.getElementById('modalTambah').classList.remove('hidden'); }
    function closeModalTambah(){ document.getElementById('modalTambah').classList.add('hidden'); }

    function openModalEdit(data){
        document.getElementById('modalEdit').classList.remove('hidden');
        
        document.getElementById('formEdit').action = '/gaji/' + data.id_gaji;
        document.getElementById('edit_input_id_karyawan').value = data.id_karyawan;
        
        document.getElementById('edit_nama_karyawan').value = data.karyawan ? data.karyawan.nama : 'Karyawan Dihapus';
        document.getElementById('edit_bulan').value = data.bulan;
        document.getElementById('edit_tahun').value = data.tahun;
        document.getElementById('edit_gaji_pokok').value = data.gaji_pokok;
        document.getElementById('edit_tunjangan').value = data.tunjangan;
        document.getElementById('edit_potongan').value = data.potongan;
    }

    function closeModalEdit(){ document.getElementById('modalEdit').classList.add('hidden'); }
</script>
@endsection
