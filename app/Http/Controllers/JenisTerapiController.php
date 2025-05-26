<?php

namespace App\Http\Controllers;

use App\Models\JenisTerampil as JenisTerapi;
use Illuminate\Http\Request;

class JenisTerapiController extends Controller
{
    public function index(){
        $this->authorize('viewAny', JenisTerapi::class);
        $jenisTerapi = JenisTerapi::all();
        if($jenisTerapi->isEmpty()){
            return response()->json([
                'status' => false,
                'message' => 'Data Jenis Terapi Kosong',
                'data' => null
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'List Data Jenis Terapi',
            'data' => JenisTerapi::all()
        ]);
    }

    public function show($id){
        $this->authorize('view', JenisTerapi::class);
        $jenisTerapi = JenisTerapi::find($id);
        if(!$jenisTerapi){
            return response()->json([
                'status' => false,
                'message' => 'Data Jenis Terapi Tidak Ditemukan',
                'data' => null
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Detail Data Jenis Terapi',
            'data' => $jenisTerapi
        ]);
    }

    public function store(Request $request){
        $this->authorize('create', JenisTerapi::class);
        $request->validate([
            'nama_terapi' => 'required',
            'deskripsi_terapi' => 'required'
        ]);
        $jenisTerapi = JenisTerapi::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Data Jenis Terapi Berhasil Ditambahkan',
            'data' => $jenisTerapi
        ]);
    }

    public function update(Request $request, $id){
        $this->authorize('update', JenisTerapi::class);
        $jenisTerapi = JenisTerapi::find($id);
        if(!$jenisTerapi){
            return response()->json([
                'status' => false,
                'message' => 'Data Jenis Terapi Tidak Ditemukan',
                'data' => null
            ]);
        }
        $jenisTerapi->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Data Jenis Terapi Berhasil Diupdate',
            'data' => $jenisTerapi
        ]);
    }

    public function destroy($id){
        $this->authorize('delete', JenisTerapi::class);
        $jenisTerapi = JenisTerapi::find($id);
        if(!$jenisTerapi){
            return response()->json([
                'status' => false,
                'message' => 'Data Jenis Terapi Tidak Ditemukan',
                'data' => null
            ]);
        }
        $jenisTerapi->delete();
        return response()->json([
            'status' => true,
            'message' => 'Data Jenis Terapi Berhasil Dihapus',
            'data' => null
        ]);
    }
}
