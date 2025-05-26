<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnosis;
class DiagnosisController extends Controller
{
    public function index(){
        $this->authorize('viewAny', Diagnosis::class);
        $diagnosis = Diagnosis::all();
        if($diagnosis->isEmpty()){
            return response()->json([
                'status' => false,
                'message' => 'Data Diagnosis Kosong',
                'data' => null
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'List Data Diagnosis',
            'data' => Diagnosis::all()
        ]);
    }

    public function show($id){
        $this->authorize('view', Diagnosis::class);
        $diagnosis = Diagnosis::find($id);
        if(!$diagnosis){
            return response()->json([
                'status' => false,
                'message' => 'Data Diagnosis Tidak Ditemukan',
                'data' => null
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Detail Data Diagnosis',
            'data' => $diagnosis
        ]);
    }

    public function store(Request $request){
        $this->authorize('create', Diagnosis::class);
        $request->validate([
            'nama_diagnosis' => 'required',
            'deskripsi_diagnosis' => 'required'
        ]);
        $diagnosis = Diagnosis::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Data Diagnosis Berhasil Ditambahkan',
            'data' => $diagnosis
        ]);
    }

    public function update(Request $request, $id){
        $this->authorize('update', Diagnosis::class);
        $diagnosis = Diagnosis::find($id);
        if(!$diagnosis){
            return response()->json([
                'status' => false,
                'message' => 'Data Diagnosis Tidak Ditemukan',
                'data' => null
            ]);
        }
        $request->validate([
            'nama_diagnosis' => 'required',
            'deskripsi_diagnosis' => 'required'
        ]);
        $diagnosis->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Data Diagnosis Berhasil Diupdate',
            'data' => $diagnosis
        ]);
    }

    public function destroy($id){
        $this->authorize('delete', Diagnosis::class);
        $diagnosis = Diagnosis::find($id);
        if(!$diagnosis){
            return response()->json([
                'status' => false,
                'message' => 'Data Diagnosis Tidak Ditemukan',
                'data' => null
            ]);
        }
        $diagnosis->delete();
        return response()->json([
            'status' => true,
            'message' => 'Data Diagnosis Berhasil Dihapus',
            'data' => null
        ]);
    }

}


