<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GajiKaryawan;
use App\Models\DataKaryawan;

class GajiController extends Controller
{
    public function index()
    {
        // 1. Ambil data Gaji, sekalian ambil data Karyawannya (Eager Loading)
        // 2. Urutkan berdasarkan Tahun DESC, lalu Bulan (Custom Order)
        $gaji = GajiKaryawan::with('karyawan')
            ->orderBy('tahun', 'desc')
            ->orderByRaw("FIELD(bulan, 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') DESC")
            ->get();

        // 3. Ambil data semua Karyawan untuk dropdown di Modal Tambah
        $karyawanList = DataKaryawan::orderBy('nama', 'asc')->get();

        return view('gaji.index', compact('gaji', 'karyawanList'));
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'id_karyawan' => 'required',
            'bulan'       => 'required',
            'tahun'       => 'required|numeric',
            'gaji_pokok'  => 'required|numeric',
            'tunjangan'   => 'required|numeric',
            'potongan'    => 'required|numeric',
        ]);

        // Hitung total otomatis
        $total = ($request->gaji_pokok + $request->tunjangan) - $request->potongan;

        // Simpan
        GajiKaryawan::create([
            'id_karyawan' => $request->id_karyawan,
            'bulan'       => $request->bulan,
            'tahun'       => $request->tahun,
            'gaji_pokok'  => $request->gaji_pokok,
            'tunjangan'   => $request->tunjangan,
            'potongan'    => $request->potongan,
            'total_gaji'  => $total < 0 ? 0 : $total, // Pastikan tidak minus
        ]);

        return redirect()->back()->with('success', 'Data Gaji Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $gaji = GajiKaryawan::findOrFail($id);
        
        $total = ($request->gaji_pokok + $request->tunjangan) - $request->potongan;

        $gaji->update([
            'bulan'       => $request->bulan,
            'tahun'       => $request->tahun,
            'gaji_pokok'  => $request->gaji_pokok,
            'tunjangan'   => $request->tunjangan,
            'potongan'    => $request->potongan,
            'total_gaji'  => $total < 0 ? 0 : $total,
        ]);

        return redirect()->back()->with('success', 'Data Gaji Berhasil Diupdate');
    }

    public function destroy($id)
    {
        GajiKaryawan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data Gaji Berhasil Dihapus');
    }
}
