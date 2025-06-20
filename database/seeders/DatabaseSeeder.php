<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
        RoleSeeder::class,
        PermissionSeeder::class,
        UserSeeder::class,
        BeritaSeeder::class,
        DiagnosisSeeder::class,
        JenisTerapileftSeeder::class,
        JenisKelainanCleftSeeder::class,
        PasienDataSeeder::class,
        OperasiDataSeeder::class,
        detail_userSeeder::class,
        KategoriPermohonanSeeder::class,
        PermohonanSeeder::class,
        YayasanSeeder::class,
        RatingYayasanSeeder::class,
        AddSukuPasien::class,
        ]);
    }
}
