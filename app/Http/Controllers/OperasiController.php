<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperasiController extends Controller
{
    public function index()
    {
        $operasi = Operasi::all();
        if ($operasi->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Data Operasi Kosong',
                'data' => null
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'List Data Operasi',
            'data' => $operasi
        ]);
    }

    public function show($id)
    {
        $operasi = Operasi::find($id);
        if (!$operasi) {
            return response()->json([
                'status' => false,
                'message' => 'Data Operasi Tidak Ditemukan',
                'data' => null
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Detail Data Operasi',
            'data' => $operasi
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
        'pasien_id' => 'required',
        'tanggal_operasi' => 'required|date',
        'tehnik_operasi' => 'required',
        'lokasi_operasi' => 'required',
        'foto_sebelum_operasi' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'foto_setelah_operasi' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'jenis_kelainan_cleft_id' => 'required|exists:jenis_kelainan_cleft,id',
        'jenis_terapi_id' => 'required|exists:jenis_terapi,id',
        'diagnosis_id' => 'required|exists:diagnosis,id',
        'follow_up' => 'required',
        'operator_id' => 'required|exists:users,id',
        ]);

        // if($request->hasFile('foto_sebelum_operasi')) {
        //     $request->file('foto_sebelum_operasi')->move(public_path('images'), $request->file('foto_sebelum_operasi')->getClientOriginalName());
        //     $foto_sebelum_operasi = $request->file('foto_sebelum_operasi')->getClientOriginalName(). '.'.$request->file('foto_sebelum_operasi')->getClientOriginalExtension();
        // }
        // if($request->hasFile('foto_setelah_operasi')) {
        //     $request->file('foto_setelah_operasi')->move(public_path('images'), $request->file('foto_setelah_operasi')->getClientOriginalName());
        //     $foto_setelah_operasi = $request->file('foto_setelah_operasi')->getClientOriginalName(). '.'.$request->file('foto_setelah_operasi')->getClientOriginalExtension();
        // }
        $diagnosis = Diagnosis::find($request->diagnosis_id);
        $jenisKelainanCleft = JenisKelainanCleft::find($request->jenis_kelainan_cleft_id);
        $jenisTerapi = JenisTerapi::find($request->jenis_terapi_id);
        $operator = User::find($request->operator_id);
        $pasien = Pasien::find($request->pasien_id);
        if (!$diagnosis || !$jenisKelainanCleft || !$jenisTerapi || !$operator || !$pasien) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak valid',
                'data' => null
            ]);
        }
        if($request->hasFile('foto_sebelum_operasi') && $request->hasFile('foto_setelah_operasi')) {
            $operasi = Operasi::create([
                'pasien_id' => $request->pasien_id,
                'tanggal_operasi' => $request->tanggal_operasi,
                'tehnik_operasi' => $request->tehnik_operasi,
                'lokasi_operasi' => $request->lokasi_operasi,
                'foto_sebelum_operasi' => app()->make('url')->to('/images/' . $foto_sebelum_operasi),
                'foto_setelah_operasi' => app()->make('url')->to('/images/' . $foto_setelah_operasi),
                'jenis_kelainan_cleft_id' => $request->jenis_kelainan_cleft_id,
                'jenis_terapi_id' => $request->jenis_terapi_id,
                'diagnosis_id' => $request->diagnosis_id,
                'follow_up' => $request->follow_up,
                'operator_id' => $request->operator_id,
            ]);
        }
        $operasi = Operasi::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Data Operasi Berhasil Ditambahkan',
            'data' => $operasi
        ]);
    }

    public function unlinkImage($image)
    {
        $imagePath = public_path('images/' . $image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    public function update(Request $request, $id)
    {
        $operasi = Operasi::find($id);
        if (!$operasi) {
            return response()->json([
                'status' => false,
                'message' => 'Data Operasi Tidak Ditemukan',
                'data' => null
            ]);
        }
        $request->validate([
            'pasien_id' => 'required',
            'tanggal_operasi' => 'required|date',
            'tehnik_operasi' => 'required',
            'lokasi_operasi' => 'required',
            'foto_sebelum_operasi' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_setelah_operasi' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'jenis_kelainan_cleft_id' => 'required|exists:jenis_kelainan_cleft,id',
            'jenis_terapi_id' => 'required|exists:jenis_terapi,id',
            'diagnosis_id' => 'required|exists:diagnosis,id',
            'follow_up' => 'required',
            'operator_id' => 'required|exists:users,id',
        ]);


        if ($request->hasFile('foto_sebelum_operasi') && $request->hasFile('foto_setelah_operasi')) {
            $this->unlinkImage($operasi->foto_sebelum_operasi);
            $this->unlinkImage($operasi->foto_setelah_operasi);
            $operasi->update([
                'pasien_id' => $request->pasien_id,
                'tanggal_operasi' => $request->tanggal_operasi,
                'tehnik_operasi' => $request->tehnik_operasi,
                'lokasi_operasi' => $request->lokasi_operasi,
                'foto_sebelum_operasi' => app()->make('url')->to('/images/' . $foto_sebelum_operasi),
                'foto_setelah_operasi' => app()->make('url')->to('/images/' . $foto_setelah_operasi),
                'jenis_kelainan_cleft_id' => $request->jenis_kelainan_cleft_id,
                'jenis_terapi_id' => $request->jenis_terapi_id,
                'diagnosis_id' => $request->diagnosis_id,
                'follow_up' => $request->follow_up,
                'operator_id' => $request->operator_id,
            ]);
        } else {
            $operasi->update($request->all());
        }
        return response()->json([
            'status' => true,
            'message' => 'Data Operasi Berhasil Diupdate',
            'data' => $operasi
        ]);
    }

    public function destroy($id)
    {
        $operasi = Operasi::find($id);
        if (!$operasi) {
            return response()->json([
                'status' => false,
                'message' => 'Data Operasi Tidak Ditemukan',
                'data' => null
            ]);
        }
        $this->unlinkImage($operasi->foto_sebelum_operasi);
        $this->unlinkImage($operasi->foto_setelah_operasi);
        $operasi->delete();
        return response()->json([
            'status' => true,
            'message' => 'Data Operasi Berhasil Dihapus',
            'data' => null
        ]);
    }
}
