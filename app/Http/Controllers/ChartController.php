<?php

namespace App\Http\Controllers;

use App\Models\detailUser;
use App\Models\JenisTerampil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function dashhart(){
    return response()->json([
        'status' => 'success',
        'message' => 'Data retrieved successfully',
        'chart_pekerjaan' => detailUser::select('pekerjaan', DB::raw('count(*) as total'))
            ->groupBy('pekerjaan')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->pekerjaan => $item->total];
            }),
        'chart_jenis_terapi'=> JenisTerampil::withcount('operasi')->get()->map(function ($item) {
            return [
                'nama_terapi' => $item->nama_terapi,
                'jumlah_operasi' => $item->operasi_count,
            ];
        }),
        'chart_jenis_kelamin'=> detailUser::select('jenis_kelamin', DB::raw('count(*) as total'))
            ->groupBy('jenis_kelamin')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->jenis_kelamin => $item->total];
            }),

    ]);
    }
}
