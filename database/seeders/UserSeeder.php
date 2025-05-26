<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\support\Str;

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
        $admin->assignRole('admin');
        $user = User::create([
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => Hash::make('password'),
        ]);
        $user->assignRole('user');
        $operator = User::create([
                'name' => 'operator',
                'email' => 'operator@gmail.com',
                'password' => Hash::make('password'),
        ]);
        $operator->assignRole('operator');

        for ($i=0; $i < 10 ; $i++) {
            $user = User::create([
                'name' => 'User ' . $i,
                'email' => 'user-' . $i .'-'. Str::random(10) . '@gmail.com',
                'password' => Hash::make('password'),
            ]);
            $user->assignRole('user');
        }

        for ($i=1; $i < 10 ; $i++) {
            $operator = User::create([
                'name' => 'operator ' . $i,
                'email' => 'operator-' . $i .'-'. Str::random(10) . '@gmail.com',
                'password' => Hash::make('password'),
            ]);
            $user->assignRole('operator');
        }


    }
}
