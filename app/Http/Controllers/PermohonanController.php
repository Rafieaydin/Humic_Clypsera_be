<?php

namespace App\Http\Controllers;

use App\Models\kategoriPermohonan;
use Illuminate\Http\Request;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Validator;

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

    public function UpdateStatus(Request $request, $id)
    {
        $permohonan = Permohonan::find($id);
        if (!$permohonan) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $request->validate([
            'status_permohonan' => 'required|string|in:pending,approved,rejected',
        ]);

        $permohonan->update(['status_permohonan' => $request->status_permohonan]);

        return response()->json([
            'message' => 'Status updated successfully',
            'data' => $permohonan->load(['kategori','operasi']),
        ], 200);
    }

    public function search(Request $request)
    {
        Validator::make($request->query(), [
            'id' => 'integer|exists:permohonan_data,id',
            'nama_pemohon' => 'string|min:3|max:255',
            'nik_pemohon' => 'string|min:10|max:15',
            'email_pemohon' => 'email',
            'no_telepon' => 'string|min:10|max:15',
            'status_permohonan' => 'string|in:pending,approved,rejected',
        ])->validate();

        $query = Permohonan::with(['kategori','operasi']);
        $listQuery = ['id', 'nama_pemohon', 'nik_pemohon', 'email_pemohon', 'no_telepon', 'status_permohonan'];
        foreach ($listQuery as $key) {
            if(!in_array($key,$listQuery)){
                return response()->json(['message' => 'Invalid query parameter: ' . $key], 400);
            }
        }

        if ($request->has('id')) {
            $query->where('id', $request->id);
        }
        if ($request->has('nama_pemohon')) {
            $query->where('nama_pemohon', 'like', '%' . $request->nama_pemohon . '%');
        }
        if ($request->has('nik_pemohon')) {
            $query->where('nik_pemohon', $request->nik_pemohon);
        }
        if ($request->has('email_pemohon')) {
            $query->where('email_pemohon', $request->email_pemohon);
        }
        if ($request->has('no_telepon')) {
            $query->where('no_telepon', $request->no_telepon);
        }
        if ($request->has('status_permohonan')) {
            $query->where('status_permohonan', $request->status_permohonan);
        }

        $permohonan = $query->get();

        if ($permohonan->isEmpty()) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'Data ditemukan',
            'data' => $permohonan,
        ], 200);
    }

}
