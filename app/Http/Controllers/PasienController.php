<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;

class PasienController extends Controller
{
    public function index(){
        $pasien = Pasien::all();
        if($pasien->isEmpty()){
            return response()->json([
                'status' => false,
                'message' => 'Data Pasien Kosong',
                'data' => null
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'List Data Pasien',
            'data' => Pasien::all()
        ]);
    }

    public function show($id){
        $pasien = Pasien::find($id);
        if(!$pasien){
            return response()->json([
                'status' => false,
                'message' => 'Data Pasien Tidak Ditemukan',
                'data' => null
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Detail Data Pasien',
            'data' => $pasien
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'nama_pasien' => 'required',
            'tanggal_lahir' => 'required',
            'umur_pasien' => 'required|integer',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat_pasien' => 'required',
            'no_telepon' => 'required|numeric',
            'pasien_anak_ke_berapa' => 'required|integer',
            'kelainan_kotigental' => 'required',
            'riwayat_kehamilan' => 'required',
            'riwayat_keluarga_pasien' => 'required',
            'riwayat_kawin_berabat' => 'required',
            'riwayat_terdahulu' => 'required',
            'operator_id' => 'required|exists:users,id',
        ]);
        $pasien = Pasien::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Data Pasien Berhasil Ditambahkan',
            'data' => $pasien
        ]);
    }

    public function update(Request $request, $id){
        $pasien = Pasien::find($id);
        if(!$pasien){
            return response()->json([
                'status' => false,
                'message' => 'Data Pasien Tidak Ditemukan',
                'data' => null
            ]);
        }
        $pasien->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Data Pasien Berhasil Diupdate',
            'data' => $pasien
        ]);
    }

    public function destroy($id){
        $pasien = Pasien::find($id);
        if(!$pasien){
            return response()->json([
                'status' => false,
                'message' => 'Data Pasien Tidak Ditemukan',
                'data' => null
            ]);
        }
        $pasien->delete();
        return response()->json([
            'status' => true,
            'message' => 'Data Pasien Berhasil Dihapus',
            'data' => null
        ]);
    }


}
