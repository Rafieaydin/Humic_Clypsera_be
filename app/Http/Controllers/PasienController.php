<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Operasi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PasienController extends Controller
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
        $this->authorize('viewAny', Pasien::class);
        $pasien = Pasien::with(['operasi'=> fn ($query) =>
            $query->with(['jenisKelainan', 'jenisTerapi', 'diagnosis', 'operator'])
        ])->orderBy('id','DESC')->get();
        if ($pasien->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Data Pasien Kosong',
                'data' => null
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'List Data Pasien',
            'data' => $pasien
        ]);
    }
    public function store(Request $request)
    {
        $this->authorize('create', Pasien::class);
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


        $pasien = Pasien::with(['operasi'=> fn ($query) =>
            $query->with(['jenisKelainan', 'jenisTerapi', 'diagnosis', 'operator'])
        ])->where('id', $pasien->id)->get();

        return response()->json([
            'status' => true,
            'message' => 'Data Pasien Berhasil Ditambahkan',
            'data' => $pasien
        ], 202);
    }

    public function show($id)
    {
        $this->authorize('view', Pasien::class);
        $pasien = Pasien::with(['operasi'=> fn ($query) =>
            $query->with(['jenisKelainan', 'jenisTerapi', 'diagnosis', 'operator'])
        ])->where('id', $id)->get();
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

    public  function update(Request $request, $id)
    {
        $this->authorize('update', Pasien::class);
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
            'nama_penyelenggara' => 'required|string|max:100',
            'operator_id' => 'required|exists:users,id',
            'suku_pasien' => 'nullable|string|max:50',
        ]);
        $foto_sebelum_operasi = null;
        $foto_setelah_operasi = null;

            if($request->hasFile('foto_sebelum_operasi') && $request->file('foto_sebelum_operasi')->isValid()){
                if ($pasien->operasi->foto_sebelum_operasi !== '/images/data_pasien/default.png') {
                    $this->unlinkImage($pasien->operasi->foto_sebelum_operasi);
                }
                $foto_sebelum_operasi = Str::random(10).'-'.$request->lokasi_operasi.'-'.$request->nama_pasien.'sebelum_operasi'.'.'.$request->file('foto_sebelum_operasi')->getClientOriginalExtension();
                $request->file('foto_sebelum_operasi')->move('images/data_pasien/',$foto_sebelum_operasi);
            }

            if($request->hasFile('foto_setelah_operasi') && $request->file('foto_setelah_operasi')->isValid()){
                if ($pasien->operasi->foto_setelah_operasi !== '/images/data_pasien/default.png') {
                    $this->unlinkImage($pasien->operasi->foto_setelah_operasi);
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
            'foto_sebelum_operasi' => ($foto_sebelum_operasi ? ('/images/data_pasien/' . $foto_sebelum_operasi) : $pasien->operasi->foto_sebelum_operasi) ?? '/images/data_pasien/default.png',
            'foto_setelah_operasi' => ($foto_setelah_operasi ? ('/images/data_pasien/' . $foto_setelah_operasi) : $pasien->operasi->foto_setelah_operasi) ?? '/images/data_pasien/default.png',
            'jenis_kelainan_cleft_id' => $request->jenis_kelainan_cleft_id,
            'jenis_terapi_id' => $request->jenis_terapi_id,
            'diagnosis_id' => $request->diagnosis_id,
            'follow_up' => $request->follow_up,
            'nama_penyelenggara' => $request->nama_penyelenggara,
            // 'operator_id' => $request->operator_id,
        ]);
        $pasien = Pasien::with(['operasi'=> fn ($query) =>
            $query->with(['jenisKelainan', 'jenisTerapi', 'diagnosis', 'operator'])
        ])->where('id', $pasien->id)->get();

        return response()->json([
            'status' => true,
            'message' => 'Data Pasien Berhasil Diupdate',
            'data' => $pasien
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('delete', Pasien::class);
        $pasien = Pasien::where('id', $id)->with('operasi')->first();
        if (!$pasien) {
            return response()->json([
                'status' => false,
                'message' => 'Data Pasien Tidak Ditemukan',
            ], 404);
        }
        if ($pasien->operasi->foto_sebelum_operasi !== '/images/data_pasien/default.png') {
            $this->unlinkImage($pasien->operasi->foto_sebelum_operasi);
        }
        if ($pasien->operasi->foto_setelah_operasi !== '/images/data_pasien/default.png') {
            $this->unlinkImage($pasien->operasi->foto_setelah_operasi);
        }
        $pasien->operasi()->delete();
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
        $queryList = ['nama_pasien', 'tanggal_lahir', 'jenis_kelamin', 'umur_pasien','no_telepon','tanggal_operasi', 'lokasi_operasi','tehnik_operasi'];
        $operationQuery = ['tanggal_operasi', 'lokasi_operasi','tehnik_operasi'];
        $query = $request->query();
        // cek query nya harus sama
        $pasien = Pasien::query();
        foreach ($query as $key => $field) {
            if (!in_array($key, $queryList)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid query parameter: ' . $key,
                ], 422);
            }
            if(in_array($key, $operationQuery)){
                $pasien->whereHas('operasi', function ($query) use ($key, $field) {

                    $query->where($key, 'like', '%' . $field . '%');
                });
            }else{
                if($key =='tanggal_lahir'){
                    try {
                        $field = Carbon::parse($field)->format('Y-m-d');
                        $pasien->whereDate($key, $field);
                    } catch (\Exception $e) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Invalid date format for tanggal_lahir',
                        ], 422);
                        }
                }else{
                    $pasien->where($key, 'like', '%' . $field . '%');
                }
            }
        }
        $pasien = $pasien->with(['operasi'=> fn ($query) =>
            $query->with(['jenisKelainan', 'jenisTerapi', 'diagnosis', 'operator'])
        ])->get();

        if ($pasien->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Data Pasien Tidak Ditemukan',
                'data' => null
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Data Pasien Ditemukan',
            'data' => $pasien
        ]);
    }


}
