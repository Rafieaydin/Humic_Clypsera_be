<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnosis;
class DiagnosisController extends Controller
{
    public function index(){
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


