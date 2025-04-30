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
