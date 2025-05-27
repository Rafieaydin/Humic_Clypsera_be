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
        $this->createPermission();
        $rule_permission = [
            'admin' => [
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
                'kagori-permohonan-list',
                'kagori-permohonan-create',
                'kagori-permohonan-edit',
                'kagori-permohonan-delete',
                'kagori-permohonan-show',
                'permohonan-list',
                'permohonan-create',
                'permohonan-edit',
                'permohonan-delete',
                'permohonan-show',
            ],
            'operator' => [
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
                'kagori-permohonan-list',
                'kagori-permohonan-create',
                'kagori-permohonan-edit',
                'kagori-permohonan-delete',
                'kagori-permohonan-show',
                'permohonan-list',
                'permohonan-create',
                'permohonan-edit',
                'permohonan-delete',
                'permohonan-show',
            ],
            'user' => [
                'berita-list',
                'berita-show',
                'diagnosis-list',
                'diagnosis-show',
                'jenis-terapi-list',
                'jenis-terapi-show',
                'jenis-kelainan-list',
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
                'kagori-permohonan-list',
                'kagori-permohonan-show',
                'permohonan-list',
                'permohonan-show',
            ],
        ];
        $this->asignRoleToPermission($rule_permission);
    }

    public function asignRoleToPermission($rule_permission = [])
    {
        foreach ($rule_permission as $roleName => $permissions) {
            $role = Role::where(['name' => $roleName, 'guard_name' => 'api'])->first();
            $role->syncPermissions($permissions);
        }
    }

    public function createPermission(){
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
            'kagori-permohonan-list',
            'kagori-permohonan-create',
            'kagori-permohonan-edit',
            'kagori-permohonan-delete',
            'kagori-permohonan-show',
            'permohonan-list',
            'permohonan-create',
            'permohonan-edit',
            'permohonan-delete',
            'permohonan-show',
        ];
        foreach ($availablePermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'api']);
        }
    }

}
