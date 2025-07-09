<?php

namespace App\Http\Controllers;

use App\Models\permohonan;
use App\Models\PermohonanToken;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use STS\ZipStream\Facades\Zip;

class ZipController extends Controller
{
    public function exportAlldataCSV(){
        return Excel::download(new \App\Exports\ExportData, 'data_pasien.xlsx' );
    }
    public function exportDataByIdCSV($id){
        return Excel::download(new \App\Exports\ExportDataByID($id), 'data_pasien_' . $id . '.xlsx');
    }

    public function exportDataPeromohonCSV($token = null)
    {
        $permohonantoken = PermohonanToken::where('token', $token)->first();
        if (!$permohonantoken || !$permohonantoken->permohonanData) {
            return response()->json(['message' => 'Token not found'], 404);
        }
        $id = $permohonantoken->permohonanData->id;
        $permohonan = permohonan::find($id);
        if (!$permohonan && $id !== null) {
            return response()->json(['message' => 'Permohonan not found'], 404);
        }
        if($permohonan && $permohonan->status_permohonan !== 'approved'){
            return response()->json(['message' => 'Permohonan is not approved'], 403);
        }


        try{
            if(($permohonan->scope ?? '') == 'semua' || $id === null){
                return $this->exportAlldataCSV();
            } else {
                return $this->exportDataByIdCSV($permohonan->operasi_id);
            }
        }catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    // public function exportAllZip(){
    //     try {
    //         $path = glob(public_path('images/data_pasien') . '/*'); // mengambil semua data di folder
    //         $zip = Zip::create('all_data.zip');

    //         foreach($path as $file){
    //             $zip->add($file, '/image/' .basename($file));
    //         }
    //         return $zip;
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }
}
