<?php

namespace App\Http\Controllers;

use App\Models\kategoriPermohonan;
use Illuminate\Http\Request;
use App\Models\Permohonan;

class PermohonanController extends Controller
{
    public function index()
    {
        $permohonan = Permohonan::with(['kategori','operasi'])->get();
        if ($permohonan->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }
        return response()->json([
            'data' => $permohonan,
        ], 200);
    }

    public function find($id)
    {
        $permohonan = Permohonan::with(['kategori','operasi'])->find($id);
        if (!$permohonan) {
            return response()->json(['message' => 'Data not found'], 404);
        }
        return response()->json([
            'data' => $permohonan,
        ], 200);
    }

    public function store(Request $request)
    {
        // $kategori = kategoriPermohonan::find($request->kategori_id);
        // $operasi = kategoriPermohonan::find($request->operasi_id);
        // if($kategori->isEmpty()){
        //     return response()->json(['message' => 'Kategori not found'], 404);
        // }
        // if($operasi->isEmpty()){
        //     return response()->json(['message' => 'Operasi not found'], 404);
        // }

        $request->validate([
            'kategori_id' => 'required|integer|exists:kategori_peromohonan,id',
            'nama_pemohon' => 'required|string|min:5|max:255',
            'nik_pemohon' => 'required|string|min:10|max:15|unique:permohonan_data,nik_pemohon',
            'email_pemohon' => 'required|email|unique:permohonan_data,email_pemohon',
            'no_telepon' => 'required|string|min:10|max:15',
            'status_permohonan' => 'required|string|in:pending,approved,rejected',
            'alasan_permohonan' => 'required|string|min:10|max:255',
            'operasi_id' => 'required|integer|exists:operasi,id',
        ]);


        $permohonan = Permohonan::create($request->all());

        return response()->json([
            'message' => 'Permohonan created successfully',
            'data' => $permohonan->load(['kategori','operasi']),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $permohonan = Permohonan::find($id);
        if (!$permohonan) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $request->validate([
            'kategori_id' => 'required|integer|exists:kategori_peromohonan,id',
            'nama_pemohon' => 'required|string|min:5|max:255',
            'nik_pemohon' => 'required|string|min:10|max:15|unique:permohonan_data,nik_pemohon,'.$id,
            'email_pemohon' => 'required|email|unique:permohonan_data,email_pemohon,'.$id,
            'no_telepon' => 'required|string|min:10|max:15',
            'status_permohonan' => 'required|string|in:pending,approved,rejected',
            'alasan_permohonan' => 'required|string|min:10|max:255',
            'operasi_id' => 'required|integer|exists:operasi,id',
        ]);

        $permohonan->update($request->all());

        return response()->json([
            'message' => 'Permohonan updated successfully',
            'data' => $permohonan->load(['kategori','operasi']),
        ], 200);
    }

    public function destroy($id)
    {
        $permohonan = Permohonan::find($id);
        if (!$permohonan) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $permohonan->delete();

        return response()->json([
            'message' => 'Permohonan deleted successfully',
        ], 200);
    }

}
