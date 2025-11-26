{{-- 1. Panggil File Induk --}}
@extends('layouts/app')

{{-- 2. Isi Judul Tab --}}
@section('title', 'Kelola Data Karyawan')

{{-- 3. Isi Konten Utama --}}
@section('content')

    {{-- Navigasi Atas --}}
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mb-6">
        <a href="{{ route('dashboard') }}" class="w-full sm:w-auto text-center bg-black text-white px-5 py-2 font-semibold hover:bg-gray-800 rounded-sm transition">
            Kembali
        </a>
        <a href="{{ route('gaji.index') }}" class="w-full sm:w-auto text-center bg-white text-green-600 border border-green-600 px-5 py-2 font-semibold hover:bg-green-50 rounded-sm transition">
            Gaji Karyawan
        </a>
    </div>

    <div class="bg-white shadow-lg w-full p-8 rounded-md">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
            <h2 class="text-lg font-bold tracking-widest text-gray-800 border-b pb-2">KELOLA DATA KARYAWAN</h2>
            <button onclick="openModalTambah()" class="cursor-pointer bg-green-600 text-white px-5 py-2 rounded-full font-semibold hover:bg-green-700 transition shadow">
                + Add Data
            </button>
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
                                class="cursor-pointer text-green-600 hover:text-green-800 p-1">
                                <i class="ri-edit-2-fill text-xl"></i>
                            </button>
                            
                            <form action="{{ route('karyawan.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini? Data gaji terkait juga akan terhapus.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="cursor-pointer text-red-600 hover:text-red-800 p-1">
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

    {{-- Modal Tambah --}}
    <div id="modalTambah" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="background-color: rgba(0, 0, 0, 0.2); backdrop-filter: blur(4px);">
        <div class="bg-white w-full max-w-md rounded-xl shadow-2xl overflow-hidden transform transition-all scale-100">
            <div class="bg-green-600 text-white text-center py-3 text-lg font-semibold shadow-md">
                Tambah Data Karyawan
            </div>
            <form action="{{ route('karyawan.store') }}" method="POST" class="p-6 space-y-4 flex flex-col">
                @csrf
                <div>
                    <label class="block font-semibold mb-1">
                        Nama
                    <input type="text" name="nama" class="border border-gray-400 rounded w-full hover:bg-gray-100 px-3 py-2" required>
                    </label>
                </div>

                <div>
                    <label class="block font-semibold mb-1">
                        Jabatan
                    <input type="text" name="jabatan" class="border border-gray-400 rounded w-full hover:bg-gray-100 px-3 py-2" required>
                    </label>
                </div>

                <div>
                    <label class="block font-semibold mb-1">
                        Alamat
                    <input type="text" name="alamat" class="border border-gray-400 rounded w-full hover:bg-gray-100 px-3 py-2" required>
                    </label>
                </div>

                <div>
                    <label class="block font-semibold mb-1">
                        No Telp
                    <input type="text" name="no_telp" class="border border-gray-400 rounded w-full hover:bg-gray-100 px-3 py-2" placeholder="628..." required>
                    <p class="text-xs text-gray-400 mt-1">*Awali dengan 628</p>
                    </label>
                </div>

                <div class="flex justify-end space-x-3 mt-2">
                    <button type="button" onclick="closeModalTambah()" class="cursor-pointer px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-100 transition">Batal</button>
                    <button type="submit" class="cursor-pointer bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 shadow-md transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div id="modalEdit" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="background-color: rgba(0, 0, 0, 0.2); backdrop-filter: blur(4px);">
        <div class="bg-white w-full max-w-md rounded-xl shadow-2xl overflow-hidden transform transition-all scale-100">
            <div class="bg-green-600 text-white text-center py-3 text-lg font-semibold">
                Edit Data Karyawan
            </div>
            <form id="formEdit" method="POST" class="p-6 space-y-4 flex flex-col">
                @csrf
                @method('PUT')
                <div>
                    <label class="block font-semibold mb-1">
                        Nama
                    <input type="text" name="nama" id="edit_nama" class="border border-gray-400 rounded w-full hover:bg-gray-100 px-3 py-2" required>
                    </label>
                </div>

                <div>
                    <label class="block font-semibold mb-1">
                        Jabatan
                    <input type="text" name="jabatan" id="edit_jabatan" class="border border-gray-400 rounded w-full hover:bg-gray-100 px-3 py-2" required>
                    </label>
                </div>

                <div>
                    <label class="block font-semibold mb-1">
                        Alamat
                    <input type="text" name="alamat" id="edit_alamat" class="border border-gray-400 rounded w-full hover:bg-gray-100 px-3 py-2" required>
                    </label>
                </div>

                <div>
                    <label class="block font-semibold mb-1">
                        No Telp
                    <input type="text" name="no_telp" id="edit_no_telp" class="border border-gray-400 rounded w-full hover:bg-gray-100 px-3 py-2" required>
                    </label>
                </div>

                <div class="flex justify-end space-x-3 mt-2">
                    <button type="button" onclick="closeModalEdit()" class="cursor-pointer px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-100 transition">Batal</button>
                    <button type="submit" class="cursor-pointer bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 shadow-md transition">Update</button>
                </div>
            </form>
        </div>
    </div>

@endsection

{{-- 4. Isi Script Javascript --}}
@section('scripts')
<script>
    function openModalTambah() { document.getElementById('modalTambah').classList.remove('hidden'); }
    function closeModalTambah() { document.getElementById('modalTambah').classList.add('hidden'); }

    function editData(id, nama, jabatan, alamat, no_telp) {
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_jabatan').value = jabatan;
        document.getElementById('edit_alamat').value = alamat;
        document.getElementById('edit_no_telp').value = no_telp;
        
        let form = document.getElementById('formEdit');
        form.action = '/karyawan/' + id;
        
        document.getElementById('modalEdit').classList.remove('hidden');
    }

    function closeModalEdit() { document.getElementById('modalEdit').classList.add('hidden'); }
</script>
@endsection
