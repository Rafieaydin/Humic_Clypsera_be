<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BeritaController extends Controller
{

    public function index()
    {
        $this->authorize('viewAny', Berita::class);
        return response()->json([
            'message' => 'Berita list',
            'data' => Berita::with('user')->orderBy('id','desc')->get(),
        ]);
    }

    public function show($id)
    {
        $berita = Berita::with('user')->findOrFail($id);
        return response()->json([
            'message' => 'Berita detail',
            'data' => $berita,
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Berita::class);
        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:10000',
            'content' => 'required|string',
            'sumber' => 'required|url',
            'status' => 'required|in:draft,published',
            'user_id' => 'required|exists:users,id',
        ]);
        $gambar = null;
        if($request->hasFile('gambar')) {
            $request->file('gambar')->move(public_path('images'), $request->file('gambar')->getClientOriginalName());
            $gambar = $request->file('gambar')->getClientOriginalName(). '.'.$request->file('gambar')->getClientOriginalExtension();
        }

        $berita = Berita::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'gambar' => app()->make('url')->to('/images/' . $gambar),
            'content' => $request->content,
            'sumber' => $request->sumber,
            'status' => $request->status,
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'message' => 'Berita created successfully',
            'data' => $berita,
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $this->authorize('update', Berita::class);
        $berita = Berita::findOrFail($id);

        $request->validate([
            'judul' => 'sometimes|required|string|max:255',
            'gambar' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'sometimes|required|string',
            'sumber' => 'sometimes|required|url',
            'status' => 'sometimes|required|in:draft,published',
            'user_id' => 'sometimes|required|exists:users,id',
        ]);

        if ($request->hasFile('gambar')) {
            $oldImage = public_path('images/' . basename($berita->gambar));
            if (file_exists($oldImage)) {
                unlink($oldImage);
            }
            $request->file('gambar')->move(public_path('images'), $request->file('gambar')->getClientOriginalName());
            $gambar = $request->file('gambar')->getClientOriginalName();
            $berita->gambar = app()->make('url')->to('/images/' . $gambar);
        }
        $berita->update([
            'judul' => $request->judul ?? $berita->judul,
            'slug' => Str::slug($request->judul ?? $berita->judul),
            'content' => $request->content ?? $berita->content,
            'sumber' => $request->sumber ?? $berita->sumber,
            'status' => $request->status ?? $berita->status,
            'user_id' => $request->user_id ?? $berita->user_id,
        ]);

        return response()->json([
            'message' => 'Berita updated successfully',
            'data' => $berita,
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('delete',Berita::class);
        $berita = Berita::findOrFail($id);
        $berita->delete();

        return response()->json([
            'message' => 'Berita deleted successfully',
        ]);
    }
}
