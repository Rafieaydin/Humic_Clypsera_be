<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Test User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
        ]);


        $admin->assignRole('admin');
        $user->assignRole('user');
    }
}
