<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataKaryawan; // Pastikan Model dipanggil

class KaryawanController extends Controller
{
    // 1. Tampilkan Data (READ)
    public function index()
    {
        $karyawan = DataKaryawan::all();
        return view('karyawan.index', compact('karyawan'));
    }

    // 2. Simpan Data Baru (CREATE)
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'alamat' => 'required',
            // Validasi: Wajib, Unik di tabel data_karyawan, Format harus 628...
            'no_telp' => ['required', 'unique:data_karyawan,no_telp', 'regex:/^628[0-9]{7,12}$/'],
        ], [
            'no_telp.regex' => 'Format nomor salah! Harus diawali 628 dan panjang yang sesuai.',
            'no_telp.unique' => 'Nomor telepon ini sudah terdaftar.',
        ]);

        // Simpan ke database
        DataKaryawan::create($request->all());

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    // 3. Update Data (UPDATE) <--- INI YANG TADI ERROR (MISSING)
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'alamat' => 'required',
            // Validasi Unik TAPI kecualikan ID karyawan yang sedang diedit
            // Syntax: unique:table,column,except_id
            'no_telp' => ['required', 'regex:/^628[0-9]{7,12}$/', 'unique:data_karyawan,no_telp,'.$id],
        ], [
            'no_telp.regex' => 'Format nomor salah! Harus diawali 628.',
            'no_telp.unique' => 'Nomor telepon ini sudah dipakai karyawan lain.',
        ]);

        // Cari data berdasarkan ID, kalau gak ketemu tampilkan error 404
        $karyawan = DataKaryawan::findOrFail($id);
        
        // Update data
        $karyawan->update($request->all());

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    // 4. Hapus Data (DELETE)
    public function destroy($id)
    {
        $karyawan = DataKaryawan::findOrFail($id);
        $karyawan->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}