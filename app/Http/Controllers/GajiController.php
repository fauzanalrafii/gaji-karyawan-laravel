<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GajiKaryawan;
use App\Models\DataKaryawan;

class GajiController extends Controller
{
    public function index()
    {
        $gaji = GajiKaryawan::ambilSemua();
        $karyawanList = DataKaryawan::ambilSemua();

        return view('gaji.index', compact('gaji', 'karyawanList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|unique:gaji_karyawan,id_karyawan,NULL,id,bulan,' . $request->bulan . ',tahun,' . $request->tahun,
            'bulan'       => 'required',
            'tahun'       => 'required|numeric',
            'gaji_pokok'  => 'required|numeric',
            'tunjangan'   => 'required|numeric',
            'potongan'    => 'required|numeric',
        ]);

        GajiKaryawan::tambah($request->all());

        return back()->with('success', 'Data Gaji Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_karyawan' => 'required',
            'bulan'       => 'required',
            'tahun'       => 'required|numeric',
            'gaji_pokok'  => 'required|numeric',
            'tunjangan'   => 'required|numeric',
            'potongan'    => 'required|numeric',
        ]);

        $isDuplicate = GajiKaryawan::cekDuplikat(
            $request->id_karyawan,
            $request->bulan,
            $request->tahun,
            $id
        );

        if ($isDuplicate) {
            return back()
                ->withErrors(['id_karyawan' => 'Slip gaji periode ini sudah ada!'])
                ->withInput();
        }

        GajiKaryawan::ubah($id, $request->all());

        return back()->with('success', 'Data Gaji Berhasil Diupdate');
    }

    public function destroy($id)
    {
        GajiKaryawan::hapus($id);
        return back()->with('success', 'Data Gaji Berhasil Dihapus');
    }
}
