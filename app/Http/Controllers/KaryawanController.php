<?php

namespace App\Http\Controllers;

use App\Models\DataKaryawan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = DataKaryawan::ambilSemua();
        return view('karyawan.index', compact('karyawan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // Validasi Nama (Huruf & Spasi)
            'nama'    => [
                'required',
                'max:100',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            // Validasi Jabatan (Huruf & Spasi)
            'jabatan' => [
                'required',
                'max:100',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            // Validasi Alamat (Huruf, Angka, Spasi, . , - / #) + Min 3 Karakter
            'alamat'  => [
                'required',
                'min:3',
                'regex:/^[a-zA-Z0-9\s\.,\-\/#]+$/'
            ],
            // Validasi No Telp
            'no_telp' => [
                'required',
                'regex:/^628[0-9]{7,12}$/',
                'unique:data_karyawan,no_telp'
            ],
        ], [
            // Custom Pesan Error
            'nama.regex'     => 'Nama hanya boleh berisi huruf dan spasi.',
            'jabatan.regex'  => 'Jabatan hanya boleh berisi huruf dan spasi.',
            
            'alamat.min'     => 'Alamat terlalu pendek, minimal 3 karakter.',
            'alamat.regex'   => 'Alamat tidak valid. Hanya boleh huruf, angka, spasi, titik (.), koma (,), minus (-), slash (/), atau pagar (#).',
            
            'no_telp.regex'  => 'Format nomor salah! Harus diawali 628 dan min 10 digit.',
            'no_telp.unique' => 'Nomor telepon ini sudah terdaftar.',
        ]);

        DataKaryawan::tambah($request->all());

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'    => [
                'required',
                'max:100',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'jabatan' => [
                'required',
                'max:100',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'alamat'  => [
                'required',
                'regex:/^[a-zA-Z0-9\s\.,\-\/#]+$/'
            ],
            'no_telp' => [
                'required',
                'regex:/^628[0-9]{7,12}$/',
                Rule::unique('data_karyawan', 'no_telp')->ignore($id),
            ],
        ], [
            'nama.regex'     => 'Nama hanya boleh berisi huruf dan spasi.',
            'jabatan.regex'  => 'Jabatan hanya boleh berisi huruf dan spasi.',
            
            'alamat.regex'   => 'Alamat tidak valid. Hanya boleh huruf, angka, spasi, titik (.), koma (,), minus (-), slash (/), atau pagar (#).',
            
            'no_telp.regex'  => 'Format nomor salah! Harus diawali 628.',
            'no_telp.unique' => 'Nomor telepon ini sudah dipakai karyawan lain.',
        ]);

        DataKaryawan::ubah($id, $request->all());

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        DataKaryawan::hapus($id);
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
