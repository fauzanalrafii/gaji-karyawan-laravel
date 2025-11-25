<?php

namespace App\Http\Controllers;

use App\Models\DataKaryawan;
use Illuminate\Http\Request;

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
            'nama'    => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'alamat'  => 'required|string|max:255',
            'no_telp' => [
                'required',
                'regex:/^628[0-9]{7,10}$/', // Harus diawali 628
                'unique:data_karyawan,no_telp' // Tidak boleh kembar
            ],
        ], [
            'no_telp.regex'  => 'Format nomor salah! Harus diawali 628 dan min 10 digit.',
            'no_telp.unique' => 'Nomor telepon ini sudah terdaftar.',
        ]);

        DataKaryawan::tambah($request->all());

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'    => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'alamat'  => 'required|string|max:255',
            'no_telp' => [
                'required',
                'regex:/^628[0-9]{7,10}$/',
                // Cek unik, tapi abaikan (ignore) ID karyawan yang sedang diedit ini
                'unique:data_karyawan,no_telp,' . $id
            ],
        ], [
            'no_telp.regex'  => 'Format nomor salah! Harus diawali 628 dan min 10 digit.',
            'no_telp.unique' => 'Nomor telepon ini sudah terdaftar.',
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
