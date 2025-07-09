<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\JenisKelainan;
use App\Models\JenisTerampil;
use App\Models\Operasi;
use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OperasiController extends Controller
{
    public function unlinkImage($image)
    {
        $imagePath = public_path($image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
    public function index()
    {
        $this->authorize('viewAny', Operasi::class);
        $pasien = Operasi::with(['pasien', 'jenisKelainan', 'jenisTerapi', 'diagnosis', 'operator'])->orderBy('id','DESC')->get();
        if ($pasien->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Data Pasien Kosong',
                'data' => null
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'List Data operasi',
            'data' => $pasien
        ]);
    }
    public function store(Request $request)
    {
        $this->authorize('create', Operasi::class);
        $request->validate([
            'nama_pasien' => 'required',
            'tanggal_lahir' => 'required',
            'umur_pasien' => 'required|integer',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat_pasien' => 'required',
            // 'no_telepon' => 'required|numeric',
            'pasien_anak_ke_berapa' => 'required|integer',
            'kelainan_kotigental' => 'required',
            'riwayat_kehamilan' => 'required',
            'riwayat_keluarga_pasien' => 'required',
            'riwayat_kawin_kerabat' => 'required',
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
            'operator_id' => 'required|exists:users,id',
            'nama_penyelenggara' => 'required|string|max:100',
            'suku_pasien' => 'nullable|string|max:50',
        ]);

        if($request->hasFile('foto_sebelum_operasi')){
            $foto_sebelum_operasi = Str::random(10).'-'.$request->lokasi_operasi.'-'.$request->nama_pasien.'sebelum_operasi'.'.'.$request->file('foto_sebelum_operasi')->getClientOriginalExtension();
            $request->file('foto_sebelum_operasi')->move('images/data_pasien/',$foto_sebelum_operasi);

        }
        if($request->hasFile('foto_setelah_operasi')){
            $foto_setelah_operasi = Str::random(10).'-'.$request->lokasi_operasi.'-'.$request->nama_pasien.'seetelah_operasi'.'.'.$request->file('foto_setelah_operasi')->getClientOriginalExtension();
            $request->file('foto_setelah_operasi')->move('images/data_pasien/',$foto_setelah_operasi);

        }

        $pasien = Pasien::create([
            'nama_pasien' => $request->nama_pasien,
            'tanggal_lahir' => $request->tanggal_lahir,
            'umur_pasien' => $request->umur_pasien,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat_pasien' => $request->alamat_pasien,
            'no_telepon' => '0000000000',
            'pasien_anak_ke_berapa' => $request->pasien_anak_ke_berapa,
            'kelainan_kotigental' => $request->kelainan_kotigental,
            'riwayat_kehamilan' => $request->riwayat_kehamilan,
            'riwayat_keluarga_pasien' => $request->riwayat_keluarga_pasien,
            'riwayat_kawin_kerabat' => $request->riwayat_kawin_kerabat,
            'riwayat_terdahulu' => $request->riwayat_terdahulu,
            'operator_id' => $request->operator_id,
            'suku_pasien' => $request->suku_pasien,
        ]);

        $operasi = Operasi::create([
            'tanggal_operasi' => $request->tanggal_operasi,
            'tehnik_operasi' => $request->tehnik_operasi,
            'lokasi_operasi' => $request->lokasi_operasi,
            'foto_sebelum_operasi' => '/images/data_pasien/' . $foto_sebelum_operasi,
            'foto_setelah_operasi' => '/images/data_pasien/' . $foto_setelah_operasi,
            'jenis_kelainan_cleft_id' => $request->jenis_kelainan_cleft_id,
            'jenis_terapi_id' => $request->jenis_terapi_id,
            'diagnosis_id' => $request->diagnosis_id,
            'follow_up' => $request->follow_up,
            'operator_id' => $request->operator_id,
            'pasien_id' => $pasien->id,
            'nama_penyelenggara' => $request->nama_penyelenggara,
        ]);



        return response()->json([
            'status' => true,
            'message' => 'Data Operasi Berhasil Ditambahkan',
            'data' => $operasi->with(['pasien', 'jenisKelainan', 'jenisTerapi', 'diagnosis', 'operator'])->find($operasi->id)
        ]);
    }

    public function show($id)
    {
        $this->authorize('view', Operasi::class);
        $pasien = Operasi::with(['pasien', 'jenisKelainan', 'jenisTerapi', 'diagnosis', 'operator'])->find($id);
        if (!$pasien) {
            return response()->json([
                'status' => false,
                'message' => 'Data Operasi Tidak Ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $pasien,
        ]);
    }

    public  function update(Request $request, $id)
    {
        $this->authorize('update', Operasi::class);
        $operasi = Operasi::with(['pasien', 'jenisKelainan', 'jenisTerapi', 'diagnosis', 'operator'])->where('id', $id)->first();
        if (!$operasi) {
            return response()->json([
                'status' => false,
                'message' => 'Data Operasi Tidak Ditemukan',
            ], 404);
        }

        $request->validate([
            'nama_pasien' => 'required',
            'tanggal_lahir' => 'required',
            'umur_pasien' => 'required|integer',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat_pasien' => 'required',
            // 'no_telepon' => 'required|numeric',
            'pasien_anak_ke_berapa' => 'required|integer',
            'kelainan_kotigental' => 'required',
            'riwayat_kehamilan' => 'required',
            'riwayat_keluarga_pasien' => 'required',
            'riwayat_kawin_kerabat' => 'required',
            'riwayat_terdahulu' => 'required',
            'tanggal_operasi' => 'required|date',
            'tehnik_operasi' => 'required',
            'lokasi_operasi' => 'required',
            // 'foto_sebelum_operasi' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'foto_setelah_operasi' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jenis_kelainan_cleft_id' => 'required|exists:jenis_kelainan_cleft,id',
            'jenis_terapi_id' => 'required|exists:jenis_terapi,id',
            'diagnosis_id' => 'required|exists:diagnosis,id',
            'follow_up' => 'required',
            'operator_id' => 'required|exists:users,id',
            'nama_penyelenggara' => 'required|string|max:100',
            'suku_pasien' => 'nullable|string|max:50',
        ]);

        $pasien = $operasi->pasien;
        if (!$pasien) {
            return response()->json([
                'status' => false,
                'message' => 'Data Pasien Tidak Ditemukan',
            ], 404);
        }
        $foto_sebelum_operasi = null;
        $foto_setelah_operasi = null;
            if($request->hasFile('foto_sebelum_operasi') && $request->file('foto_sebelum_operasi')->isValid()){
                if($operasi->foto_sebelum_operasi !== '/images/data_pasien/default.png'){
                    $this->unlinkImage($operasi->foto_sebelum_operasi);
                }
                $foto_sebelum_operasi = Str::random(10).'-'.$request->lokasi_operasi.'-'.$request->nama_pasien.'sebelum_operasi'.'.'.$request->file('foto_sebelum_operasi')->getClientOriginalExtension();
                $request->file('foto_sebelum_operasi')->move('images/data_pasien/',$foto_sebelum_operasi);
            }

            if($request->hasFile('foto_setelah_operasi') && $request->file('foto_setelah_operasi')->isValid()){
                if($operasi->foto_setelah_operasi !== '/images/data_pasien/default.png'){
                    $this->unlinkImage($operasi->foto_setelah_operasi);
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
            'no_telepon' => '0000000000',
            'pasien_anak_ke_berapa' => $request->pasien_anak_ke_berapa,
            'kelainan_kotigental' => $request->kelainan_kotigental,
            'riwayat_kehamilan' => $request->riwayat_kehamilan,
            'riwayat_keluarga_pasien' => $request->riwayat_keluarga_pasien,
            'riwayat_kawin_kerabat' => $request->riwayat_kawin_kerabat,
            'riwayat_terdahulu' => $request->riwayat_terdahulu,
            'suku_pasien' => $request->suku_pasien,
            // 'operator_id' => $request->operator_id,
        ]);

        $pasien->operasi->update([
            'tanggal_operasi' => $request->tanggal_operasi,
            'tehnik_operasi' => $request->tehnik_operasi,
            'lokasi_operasi' => $request->lokasi_operasi,
            'foto_sebelum_operasi' => ($foto_sebelum_operasi ? ('/images/data_pasien/' . $foto_sebelum_operasi) : $operasi->foto_sebelum_operasi),
            'foto_setelah_operasi' => ($foto_setelah_operasi ? ('/images/data_pasien/' . $foto_setelah_operasi) : $operasi->foto_setelah_operasi),
            'jenis_kelainan_cleft_id' => $request->jenis_kelainan_cleft_id,
            'jenis_terapi_id' => $request->jenis_terapi_id,
            'diagnosis_id' => $request->diagnosis_id,
            'follow_up' => $request->follow_up,
            'nama_penyelenggara' => $request->nama_penyelenggara,
            // 'operator_id' => $request->operator_id,
        ]);
        $operasi = Operasi::with(['pasien', 'jenisKelainan', 'jenisTerapi', 'diagnosis', 'operator'])->find($pasien->operasi->id);

        return response()->json([
            'status' => true,
            'message' => 'Data Operasi Berhasil Diupdate',
            'data' => $operasi
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('delete', Operasi::class);
        $operasi = Operasi::where('id', $id)->with(['pasien'])->first();
        if (!$operasi) {
            return response()->json([
                'status' => false,
                'message' => 'Data Pasien Tidak Ditemukan',
            ], 404);
        }

        try {
            if($operasi->foto_sebelum_operasi !== '/images/data_pasien/default.png'){
                $this->unlinkImage($operasi->foto_sebelum_operasi);
            }
            if($operasi->foto_setelah_operasi !== '/images/data_pasien/default.png'){
                $this->unlinkImage($operasi->foto_setelah_operasi);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus gambar: ' . $e->getMessage(),
            ], 500);
        }
        $operasi->pasien->delete();
        $operasi->delete();
        return response()->json([
            'status' => true,
            'message' => 'Data Operasi Berhasil Dihapus',
        ]);
    }
    public function search(Request $request)
    {
        $validate = Validator::make($request->query(), [
            'nama_pasien' => 'string|max:255',
            'umur_pasien' => 'integer|min:0',
            'jenis_kelamin' => 'in:L,P',
            'no_telepon' => 'string|max:15',
            'tanggal_lahir' => 'date',
            'tanggal_operasi' => 'date',
            'tehnik_operasi' => 'string|max:255',
            'lokasi_operasi' => 'string|max:255',
        ],
        );
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'invalid paramter',
                'errors' => $validate->errors(),
            ], 422);
        }
        $queryList = ['nama_pasien', 'tanggal_lahir', 'jenis_kelamin', 'umur_pasien', 'tanggal_operasi','no_telepon', 'lokasi_operasi','tehnik_operasi'];
        $pasientQuery = ['nama_pasien', 'tanggal_lahir', 'jenis_kelamin', 'umur_pasien', 'no_telepon'];
        $query = $request->query();
        // cek query nya harus sama
        $operasi = Operasi::query();
        foreach ($query as $key => $field) {
            if (!in_array($key, $queryList)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid query parameter: ' . $key,
                ], 422);
            }
            if(in_array($key, $pasientQuery)){
                $operasi->whereHas('pasien', function ($query) use ($key, $field) {
                    if($key =='tanggal_lahir'){
                        try {
                            $field = Carbon::parse($field)->format('Y-m-d');
                            $query->whereDate($key, $field);
                        } catch (\Exception $e) {
                            return response()->json([
                                'status' => false,
                                'message' => 'Invalid date format for tanggal_lahir',
                            ], 422);
                        }
                    }
                    $query->where($key, 'like', '%' . $field . '%');
                });
            }else{
                $operasi->where($key, 'like', '%' . $field . '%');
            }
        }
        $operasi = $operasi->with(['jenisKelainan', 'jenisTerapi', 'diagnosis', 'operator','pasien'])->get();

        if ($operasi->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Data Pasien Tidak Ditemukan',
                'data' => null
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Data Pasien Ditemukan',
            'data' => $operasi
        ]);
    }
}
