<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $availablePermissions = [
            'berita-list',
            'berita-create',
            'berita-edit',
            'berita-delete',
            'berita-show',
            'diagnosis-list',
            'diagnosis-create',
            'diagnosis-edit',
            'diagnosis-delete',
            'diagnosis-show',
            'jenis-terapi-list',
            'jenis-terapi-create',
            'jenis-terapi-edit',
            'jenis-terapi-delete',
            'jenis-terapi-show',
            'jenis-kelainan-list',
            'jenis-kelainan-create',
            'jenis-kelainan-edit',
            'jenis-kelainan-delete',
            'jenis-kelainan-show',
            'operasi-list',
            'operasi-create',
            'operasi-edit',
            'operasi-delete',
            'operasi-show',
            'pasien-list',
            'pasien-create',
            'pasien-edit',
            'pasien-delete',
            'pasien-show',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-show',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'role-show',
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
        ];
        foreach ($availablePermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'api']);
        }

        $this->asignRoleToPermission();
    }

    public function asignRoleToPermission()
    {
        $permissions = Permission::where('guard_name', 'api')->get();
        $role = Role::where('name', 'admin')->first();
        $role->syncPermissions($permissions);

        $role = Role::where('name', 'operator')->first();
        foreach ($permissions as $permission) {
            $role->syncPermissions(['berita-list', 'berita-create', 'berita-edit', 'berita-delete']);
        }

        $role = Role::where('name', 'user')->first();
        foreach ($permissions as $permission) {
            $role->syncPermissions(['berita-list']);
        }
    }

}
