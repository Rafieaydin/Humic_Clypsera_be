<?php

namespace App\Http\Controllers;

use App\Models\detailUser;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role as ModelsRole;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['detail_user','roles'])->get();
        if ($users->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }
        return response()->json([
            'data' => $users,
        ], 200);
    }

    public function show($id)
    {
        $user = User::with(['detail_user','role'])->find($id);
        if (!$user) {
            return response()->json(['message' => 'Data not found'], 404);
        }
        return response()->json([
            'data' => $user,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:10|max:255',
            'email' => 'required|email|unique:users,email,except,id',
            'password' => 'required|string|min:10|max:255',
            'password_confirmation' => 'required|string|min:10|max:255',
            'nik' => 'required|string|min:10|max:255',
            'pekerjaan' => 'required|string|min:10|max:255',
            'tanggal_lahir' => 'required|date',
            'umur' => 'required|integer',
            'alamat' => 'required|string|min:10|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'no_telepon' => 'required|string|min:10|max:255',
            'role_id' => 'required|integer',
        ]);
        $role = null;
        if ($request->filled('role_id')) {
            $role = ModelsRole::find($request->role_id);
            if (!$role) {
                return response()->json(['message' => 'Role not found'], 404);
            }
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        if($role){
            $user->assignRole($role);
        }

        detailUser::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'pekerjaan' => $request->pekerjaan,
            'tanggal_lahir' => $request->tanggal_lahir,
            'umur' => $request->umur,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telepon' => $request->no_telepon,
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user->load('detail_user','roles'),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|min:10|max:255',
            'email' => 'required|email|unique:users,email,except,id',
            'password' => 'nullable|string|min:10|max:255',
            'nik' => 'required|string|min:10|max:255',
            'pekerjaan' => 'required|string|min:10|max:255',
            'tanggal_lahir' => 'required|date',
            'umur' => 'required|integer',
            'alamat' => 'required|string|min:10|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'no_telepon' => 'required|string|min:10|max:255',
        ]);

        $role = null;
        if ($request->filled('role_id')) {
            $role = ModelsRole::find($request->role_id);
            if (!$role) {
                return response()->json(['message' => 'Role not found'], 404);
            }
        }

        if($request->filled('nik')){
            $cekNik = detailUser::where('nik', $request->nik)->where('user_id', '!=', $user->id)->first();
            if ($cekNik) {
                return response()->json(['message' => 'NIK already exists'], 400);
            }
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('role_id')) {
            $user->syncRoles($role);
        }

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->detail_user()->update([
            'nik' => $request->nik,
            'pekerjaan' => $request->pekerjaan,
            'tanggal_lahir' => $request->tanggal_lahir,
            'umur' => $request->umur,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telepon' => $request->no_telepon,
        ]);

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user->load('detail_user'),
        ], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully',
        ], 200);
    }

    public function find($id)
    {
        $user = User::with(['detail_user','roles'])->find($id);
        if (!$user) {
            return response()->json(['message' => 'Data not found'], 404);
        }
        return response()->json([
            'data' => $user,
        ], 200);
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->query(), [
            'id' => 'integer|exists:users,id',
            'name' => 'string',
            'email' => 'email',
            'nik' => 'string|min:10|max:22',
            'pekerjaan' => 'string|min:4|max:225',
            'alamat' => 'string|min:10|max:255',
            'jenis_kelamin' => 'in:L,P',
            'no_telepon' => 'string|min:10|max:255',
            'role_id' => 'integer|exists:roles,id',
        ], [
            '*' => 'Invalid query parameter: :attribute',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }
        $userDetailsQuery = ['nik', 'pekerjaan', 'alamat', 'jenis_kelamin', 'no_telepon'];
        $query = request()->query();
        $userQuery = User::query();
        foreach ($query as $key => $value) {
            if (is_null($value)) {
                continue;
            }
            if (in_array($key, $userDetailsQuery)) {
                $userQuery->whereHas('detail_user', function ($q) use ($key, $value) {
                    $q->where($key, 'LIKE', "%{$value}%");
                });
            }else{
                $userQuery->where($key, 'LIKE', "%{$value}%");
            }


        }
        $users = $userQuery->get();
        return response()->json([
            'data' => $users->load('detail_user','roles'),
        ], 200);
    }
}
