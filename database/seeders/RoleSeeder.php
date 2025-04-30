<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = ['admin','operator','user'];
        for($i = 0 ; $i < count($role); $i++){
            Role::create(['name' => $role[$i],'guard_name' => 'api']);
        }
    }
}
