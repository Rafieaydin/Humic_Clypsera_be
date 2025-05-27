<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisKelainan;

class JenisKelainanController extends Controller
{
    public function index(){
        $this->authorize('viewAny', JenisKelainan::class);
        $jenisKelainan = JenisKelainan::all();
        if($jenisKelainan->isEmpty()){
            return response()->json([
                'status' => false,
                'message' => 'Data Jenis Kelainan Kosong',
                'data' => null
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'List Data Jenis Kelainan',
            'data' => JenisKelainan::all()
        ]);
    }

    public function show($id){
        $this->authorize('view', JenisKelainan::class);
        $jenisKelainan = JenisKelainan::find($id);
        if(!$jenisKelainan){
            return response()->json([
                'status' => false,
                'message' => 'Data Jenis Kelainan Tidak Ditemukan',
                'data' => null
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Detail Data Jenis Kelainan',
            'data' => $jenisKelainan
        ]);
    }

    public function store(Request $request){
        $this->authorize('create', JenisKelainan::class);
        $request->validate([
            'nama_kelainan' => 'required',
            'deskripsi_kelainan' => 'required'
        ]);
        $jenisKelainan = JenisKelainan::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Data Jenis Kelainan Berhasil Ditambahkan',
            'data' => $jenisKelainan
        ]);
    }

    public function update(Request $request, $id){
        $this->authorize('update', JenisKelainan::class);
        $jenisKelainan = JenisKelainan::find($id);
        if(!$jenisKelainan){
            return response()->json([
                'status' => false,
                'message' => 'Data Jenis Kelainan Tidak Ditemukan',
                'data' => null
            ]);
        }
        $jenisKelainan->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Data Jenis Kelainan Berhasil Diupdate',
            'data' => $jenisKelainan
        ]);
    }

    public function destroy($id){
        $this->authorize('delete', JenisKelainan::class);
        $jenisKelainan = JenisKelainan::find($id);
        if(!$jenisKelainan){
            return response()->json([
                'status' => false,
                'message' => 'Data Jenis Kelainan Tidak Ditemukan',
                'data' => null
            ]);
        }
        $jenisKelainan->delete();
        return response()->json([
            'status' => true,
            'message' => 'Data Jenis Kelainan Berhasil Dihapus',
        ]);
    }
    // public function getOperasi($id){
    //     $jenisKelainan = JenisKelainan::with('operasi')->find($id);
    //     if(!$jenisKelainan){
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Data Jenis Kelainan Tidak Ditemukan',
    //             'data' => null
    //         ]);
    //     }
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'List Data Operasi',
    //         'data' => $jenisKelainan->operasi
    //     ]);
    // }
}
