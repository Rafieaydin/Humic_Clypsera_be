<?php

namespace App\Http\Controllers;

use App\Models\Operasi;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class inputDataController extends Controller
{
    public function store(Request $request)
    {
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
            'tanggal_operasi' => 'required|date',
            'tehnik_operasi' => 'required',
            'lokasi_operasi' => 'required',
            'foto_sebelum_operasi' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_setelah_operasi' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jenis_kelainan_cleft_id' => 'required|exists:jenis_kelainan_cleft,id',
            'jenis_terapi_id' => 'required|exists:jenis_terapi,id',
            'diagnosis_id' => 'required|exists:diagnosis,id',
            'follow_up' => 'required',
            // 'operator_id' => 'required|exists:users,id',
        ]);

        if($request->hasFile('foto_sebelum_operasi')){
            $foto_sebelum_operasi = Str::random(10).'-'.$request->lokasi_operasi.'-'.$request->nama_pasien.'sebelum_operasi'.'.'.$request->file('foto_sebelum_operasi')->getClientOriginalExtension();
            $request->file('foto_sebelum_operasi')->move('images/data_pasien/',$foto_sebelum_operasi);

        }
        if($request->hasFile('foto_setelah_operasi')){
            $foto_setelah_operasi = Str::random(10).'-'.$request->lokasi_operasi.'-'.$request->nama_pasien.'seetelah_operasi'.'.'.$request->file('foto_setelah_operasi')->getClientOriginalExtension();
            $request->file('foto_setelah_operasi')->move('images/data_pasien/',$foto_setelah_operasi);

        }

        $operasi = Operasi::create([
            'tanggal_operasi' => $request->tanggal_operasi,
            'tehnik_operasi' => $request->tehnik_operasi,
            'lokasi_operasi' => $request->lokasi_operasi,
            'foto_sebelum_operasi' => app()->make('url')->to('/images/data_pasien/' . $foto_sebelum_operasi),
            'foto_setelah_operasi' => app()->make('url')->to('/images/data_pasien/' . $foto_setelah_operasi),
            'jenis_kelainan_cleft_id' => $request->jenis_kelainan_cleft_id,
            'jenis_terapi_id' => $request->jenis_terapi_id,
            'diagnosis_id' => $request->diagnosis_id,
            'follow_up' => $request->follow_up,
            'operator_id' => $request->operator_id,
        ]);
        $pasien = Pasien::create([
            'nama_pasien' => $request->nama_pasien,
            'tanggal_lahir' => $request->tanggal_lahir,
            'umur_pasien' => $request->umur_pasien,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat_pasien' => $request->alamat_pasien,
            'no_telepon' => $request->no_telepon,
            'pasien_anak_ke_berapa' => $request->pasien_anak_ke_berapa,
            'kelainan_kotigental' => $request->kelainan_kotigental,
            'riwayat_kehamilan' => $request->riwayat_kehamilan,
            'riwayat_keluarga_pasien' => $request->riwayat_keluarga_pasien,
            'riwayat_kawin_berabat' => $request->riwayat_kawin_berabat,
            'riwayat_terdahulu' => $request->riwayat_terdahulu,
            'operator_id' => $request->operator_id,
            'operasi_id' => $operasi->id,
        ]);


        return response()->json([
            'status' => true,
            'message' => 'Data Pasien Berhasil Ditambahkan',
            'data' => $operasi->with(['pasien', 'jenisKelainan', 'jenisTerapi', 'diagnosis', 'operator'])->find($operasi->id)
        ]);
    }

    public function show($id)
    {
        $pasien = Pasien::with('operasi')->find($id);
        if (!$pasien) {
            return response()->json([
                'status' => false,
                'message' => 'Data Pasien Tidak Ditemukan',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'data' => $pasien->operasi->load(['pasien', 'jenisKelainan', 'jenisTerapi', 'diagnosis', 'operator']),
        ]);
    }

    public  function update(Request $request, $id)
    {
        $pasien = Pasien::find($id);
        if (!$pasien) {
            return response()->json([
                'status' => false,
                'message' => 'Data Pasien Tidak Ditemukan',
            ], 404);
        }

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
            'tanggal_operasi' => 'required|date',
            'tehnik_operasi' => 'required',
            'lokasi_operasi' => 'required',
            'foto_sebelum_operasi' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_setelah_operasi' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jenis_kelainan_cleft_id' => 'required|exists:jenis_kelainan_cleft,id',
            'jenis_terapi_id' => 'required|exists:jenis_terapi,id',
            'diagnosis_id' => 'required|exists:diagnosis,id',
            'follow_up' => 'required',
            // 'operator_id' => 'required|exists:users,id',
        ]);

        if($request->hasFile('foto_sebelum_operasi') && $request->file('foto_setelah_operasi')->isValid()){
            if($pasien->operasi->foto_sebelum_operasi){
                $oldImage = public_path('images/data_pasien/' . basename($pasien->operasi->foto_sebelum_operasi));
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }
            $foto_sebelum_operasi = Str::random(10).'-'.$request->lokasi_operasi.'-'.$request->nama_pasien.'sebelum_operasi'.'.'.$request->file('foto_sebelum_operasi')->getClientOriginalExtension();
            $request->file('foto_sebelum_operasi')->move('images/data_pasien/',$foto_sebelum_operasi);

            if($pasien->operasi->foto_setelah_operasi){
                $oldImage = public_path('images/data_pasien/' . basename($pasien->operasi->foto_setelah_operasi));
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }
            $foto_setelah_operasi = Str::random(10).'-'.$request->lokasi_operasi.'-'.$request->nama_pasien.'setelah_operasi'.'.'.$request->file('foto_setelah_operasi')->getClientOriginalExtension();
            $request->file('foto_setelah_operasi')->move('images/data_pasien/',$foto_setelah_operasi);
        }

        $pasien->update([
            'nama_pasien' => $request->nama_pasien,
            'tanggal_lahir' => $request->tanggal_lahir,
            'umur_pasien' => $request->umur_pasien,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat_pasien' => $request->alamat_pasien,
            'no_telepon' => $request->no_telepon,
            'pasien_anak_ke_berapa' => $request->pasien_anak_ke_berapa,
            'kelainan_kotigental' => $request->kelainan_kotigental,
            'riwayat_kehamilan' => $request->riwayat_kehamilan,
            'riwayat_keluarga_pasien' => $request->riwayat_keluarga_pasien,
            'riwayat_kawin_berabat' => $request->riwayat_kawin_berabat,
            'riwayat_terdahulu' => $request->riwayat_terdahulu,
            // 'operator_id' => $request->operator_id,
        ]);

        $pasien->operasi->update([
            'tanggal_operasi' => $request->tanggal_operasi,
            'tehnik_operasi' => $request->tehnik_operasi,
            'lokasi_operasi' => $request->lokasi_operasi,
            'foto_sebelum_operasi' => app()->make('url')->to('/images/data_pasien/' . $foto_sebelum_operasi),
            'foto_setelah_operasi' => app()->make('url')->to('/images/data_pasien/' . $foto_setelah_operasi),
            'jenis_kelainan_cleft_id' => $request->jenis_kelainan_cleft_id,
            'jenis_terapi_id' => $request->jenis_terapi_id,
            'diagnosis_id' => $request->diagnosis_id,
            'follow_up' => $request->follow_up,
            // 'operator_id' => $request->operator_id,
        ]);
        $operasi = $pasien->operasi->load(['pasien', 'jenisKelainan', 'jenisTerapi', 'diagnosis', 'operator']);

        return response()->json([
            'status' => true,
            'message' => 'Data Pasien Berhasil Diupdate',
            'data' => $operasi
        ]);
    }

    public function destroy($id)
    {
        $pasien = Pasien::find($id);
        $pasien->operasi()->delete();
        if (!$pasien) {
            return response()->json([
                'status' => false,
                'message' => 'Data Pasien Tidak Ditemukan',
            ], 404);
        }

        $pasien->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data Pasien Berhasil Dihapus',
        ]);
    }

    public function getPasienById($id)
    {
        $pasien = Pasien::with('operasi')->find($id);
        if (!$pasien) {
            return response()->json([
                'status' => false,
                'message' => 'Data Pasien Tidak Ditemukan',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'data' => $pasien,
        ]);
    }
}
