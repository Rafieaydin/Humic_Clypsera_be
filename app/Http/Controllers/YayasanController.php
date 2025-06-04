<?php

namespace App\Http\Controllers;

use App\Models\Yayasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class YayasanController extends Controller
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
        Yayasan::with('ratings')->get()->each(function ($yayasan) {
            $yayasan->average_rating = $yayasan->ratings->avg('rating');
        });
        $yayasan = Yayasan::with('ratings')->get();
        if ($yayasan->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }
        return response()->json([
            'data' => $yayasan,
        ], 200);
    }

    public function find($id)
    {
        $yayasan = Yayasan::with('ratings')->find($id);
        if (!$yayasan) {
            return response()->json(['message' => 'Data not found'], 404);
        }
        $yayasan->average_rating = $yayasan->ratings->avg('rating');
        return response()->json([
            'data' => $yayasan,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_yayasan' => 'required|string|max:255',
            'domisili_yayasan' => 'required|string|max:255',
            'alamat_yayasan' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
            'email_yayasan' => 'required|email|max:255|unique:yayasan,email_yayasan',
            'website_yayasan' => 'nullable|url|max:255',
            'deskripsi_yayasan' => 'nullable|string',
            'logo_yayasan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'visi_yayasan' => 'nullable|string',
            'misi_yayasan' => 'nullable|string',
        ]);
        if(!$request->hasFile('logo_yayasan') || !$request->file('logo_yayasan')->isValid()) {
            return response()->json(['message' => 'Invalid logo file'], 422);
        }
        if ($request->file('logo_yayasan')) {
            $name_logo = Str::random(10).'-'.implode("-",explode(" ",$request->nama_yayasan)).'.' . $request->file('logo_yayasan')->getClientOriginalExtension();
            $request->file('logo_yayasan')->move('images/logo/', $name_logo);
        }

        $yayasan = Yayasan::create([
            'nama_yayasan' => $request->nama_yayasan,
            'domisili_yayasan' => $request->domisili_yayasan,
            'alamat_yayasan' => $request->alamat_yayasan,
            'no_telepon' => $request->no_telepon,
            'email_yayasan' => $request->email_yayasan,
            'website_yayasan' => $request->website_yayasan,
            'deskripsi_yayasan' => $request->deskripsi_yayasan,
            'logo_yayasan' => '/images/logo/'.$name_logo ?? 'images/logo/default.png',
            'visi_yayasan' => $request->visi_yayasan,
            'misi_yayasan' => $request->misi_yayasan,
            'status_yayasan' => 'Belum Diverifikasi',
            'rating_yayasan' => 0.0,
        ]);

        return response()->json([
            'message' => 'Yayasan created successfully',
            'data' => $yayasan,
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $yayasan = Yayasan::find($id);
        if (!$yayasan) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $request->validate([
            'nama_yayasan' => 'required|string|max:255',
            'domisili_yayasan' => 'required|string|max:255',
            'alamat_yayasan' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15',
            'email_yayasan' => 'required|email|max:255|unique:yayasan,email_yayasan,' . $id,
            'website_yayasan' => 'nullable|url|max:255',
            'deskripsi_yayasan' => 'nullable|string',
            'logo_yayasan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'visi_yayasan' => 'nullable|string',
            'misi_yayasan' => 'nullable|string',
        ]);

        if($request->hasFile('logo_yayasan') && $request->file('logo_yayasan')->isValid()) {
            if($yayasan->logo_yayasan !== '/images/logo/default.png') {
                $this->unlinkImage($yayasan->logo_yayasan);
            }
            $name_logo = Str::random(10).'-'.implode("-",explode(" ",$request->nama_yayasan)).'.' . $request->file('logo_yayasan')->getClientOriginalExtension();
            $request->file('logo_yayasan')->move('images/logo/', $name_logo);
        }

        $yayasan->update([
            'nama_yayasan' => $request->nama_yayasan,
            'domisili_yayasan' => $request->domisili_yayasan,
            'alamat_yayasan' => $request->alamat_yayasan,
            'no_telepon' => $request->no_telepon,
            'email_yayasan' => $request->email_yayasan,
            'website_yayasan' => $request->website_yayasan,
            'deskripsi_yayasan' => $request->deskripsi_yayasan,
            'logo_yayasan' => '/images/logo/'.$name_logo ?? $yayasan->logo_yayasan,
            'visi_yayasan' => $request->visi_yayasan,
            'misi_yayasan' => $request->misi_yayasan,
        ]);

        return response()->json([
            'message' => 'Yayasan updated successfully',
            'data' => $yayasan,
        ], 200);
    }
    public function destroy($id)
    {
        $yayasan = Yayasan::find($id);
        if (!$yayasan) {
            return response()->json(['message' => 'Data not found'], 404);
        }
        if($yayasan->logo_yayasan !== '/images/logo/default.png') {
            $this->unlinkImage($yayasan->logo_yayasan);
        }

        $yayasan->delete();

        return response()->json([
            'message' => 'Yayasan deleted successfully',
        ], 200);
    }
    public function search(Request $request)
    {
        Validator::make($request->query(), [
            'nama_yayasan' => 'nullable|string|max:255',
            'domisili_yayasan' => 'nullable|string|max:255',
            'rating_yayasan' => 'nullable|numeric|min:0|max:5',
        ])->validate();
        $query = Yayasan::query();
        $listQuery = ['nama_yayasan', 'domisili_yayasan','rating_yayasan'];
        foreach ($request->query() as $key => $field) {
            if(!in_array($key, $listQuery)) {
                return response()->json(['message' => 'Invalid query parameter: ' . $key], 400);
            }
            $query->where($key, 'like', '%' . $field . '%');
        }

        $yayasan = $query->with('ratings')->get();
        if ($yayasan->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }
        return response()->json([
            'data' => $yayasan,
        ], 200);
    }
}
