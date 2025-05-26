<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kategoriPermohonan;

class KategoriPermohonanController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', kategoriPermohonan::class);
        $kategoriPeromohonan = kategoriPermohonan::with('permohonan')->get();
        if ($kategoriPeromohonan->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }
        return response()->json([
            'data' => $kategoriPeromohonan,
        ], 200);
    }

    public function find($id)
    {
        $this->authorize('view', kategoriPermohonan::class);
        $kategoriPermohonan = kategoriPermohonan::with('permohonan')->find($id);
        if (!$kategoriPermohonan) {
            return response()->json(['message' => 'Data not found'], 404);
        }
        return response()->json([
            'data' => $kategoriPermohonan,
        ], 200);
    }

    public function store(Request $request)
    {
        $this->authorize('create', kategoriPermohonan::class);
        $request->validate([
            'kategori' => 'required|string|min:10|max:255',
        ]);

        $kategoriPermohonan = kategoriPermohonan::create($request->all());

        return response()->json([
            'message' => 'Kategori permohonan created successfully',
            'data' => $kategoriPermohonan,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update', kategoriPermohonan::class);
        $kategoriPermohonan = kategoriPermohonan::find($id);
        if (!$kategoriPermohonan) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $request->validate([
            'kategori' => 'required|string|min:10|max:255',
        ]);

        $kategoriPermohonan->update($request->all());

        return response()->json([
            'message' => 'Kategori permohonan updated successfully',
            'data' => $kategoriPermohonan,
        ], 200);
    }
    public function destroy($id)
    {
        $this->authorize('delete', kategoriPermohonan::class);
        $kategoriPermohonan = kategoriPermohonan::find($id);
        if (!$kategoriPermohonan) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $kategoriPermohonan->delete();

        return response()->json([
            'message' => 'Kategori permohonan deleted successfully',
        ], 200);
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $kategoriPermohonan = kategoriPermohonan::where('kategori', 'LIKE', "%{$query}%")->get();

        if ($kategoriPermohonan->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }

        return response()->json([
            'data' => $kategoriPermohonan,
        ], 200);
    }
}
