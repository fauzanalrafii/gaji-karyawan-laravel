<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GajiKaryawan;
use App\Models\DataKaryawan;
use Illuminate\Validation\Rule;

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
            'id_karyawan' => [
                'required',
                // Cek Unik: 1 Karyawan cuma boleh 1 slip gaji per periode
                Rule::unique('gaji_karyawan')->where(function ($query) use ($request) {
                    return $query->where('bulan', $request->bulan)
                                 ->where('tahun', $request->tahun);
                }),
            ],
            'bulan'       => 'required',
            'tahun'       => 'required|numeric',
            
            // PERBAIKAN DISINI: Tambah 'min:0'
            'gaji_pokok'  => 'required|numeric|min:0',
            'tunjangan'   => 'required|numeric|min:0',
            'potongan'    => 'required|numeric|min:0',
        ], [
            'id_karyawan.unique' => 'Slip gaji untuk karyawan ini pada periode tersebut sudah ada!',
            'gaji_pokok.min'     => 'Gaji pokok tidak boleh bernilai negatif.',
            'tunjangan.min'      => 'Tunjangan tidak boleh bernilai negatif.',
            'potongan.min'       => 'Potongan tidak boleh bernilai negatif.',
        ]);

        GajiKaryawan::tambah($request->all());

        return back()->with('success', 'Data Gaji Berhasil Ditambahkan');
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi Format Input
        $request->validate([
            'id_karyawan' => 'required',
            'bulan'       => 'required',
            'tahun'       => 'required|numeric',
            
            // PERBAIKAN DISINI JUGA: Tambah 'min:0'
            'gaji_pokok'  => 'required|numeric|min:0',
            'tunjangan'   => 'required|numeric|min:0',
            'potongan'    => 'required|numeric|min:0',
        ], [
            'gaji_pokok.min' => 'Gaji pokok tidak boleh negatif.',
            'tunjangan.min'  => 'Tunjangan tidak boleh negatif.',
            'potongan.min'   => 'Potongan tidak boleh negatif.',
        ]);

        // 2. Validasi Duplikat Manual
        // Cek apakah ada data lain (selain diri sendiri) yg kembar
        $adaDuplikat = GajiKaryawan::where('id_karyawan', $request->id_karyawan)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->where('id_gaji', '!=', $id)
            ->exists();

        if ($adaDuplikat) {
            return back()
                ->withErrors(['id_karyawan' => 'Slip gaji periode ini sudah ada pada data lain!'])
                ->withInput();
        }

        // 3. Update
        GajiKaryawan::ubah($id, $request->all());
        
        return back()->with('success', 'Data Gaji Berhasil Diupdate');
    }

    public function destroy($id)
    {
        GajiKaryawan::hapus($id);
        return back()->with('success', 'Data Gaji Berhasil Dihapus');
    }
}
