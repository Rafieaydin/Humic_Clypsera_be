<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisKelainan;

class JenisKelainanController extends Controller
{
    public function index(){
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
            'data' => null
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
