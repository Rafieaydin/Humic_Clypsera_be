<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YayasanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            DB::table('yayasan')->insert([
                'nama_yayasan' => $faker->company,
                'domisili_yayasan' => $faker->city,
                'alamat_yayasan' => $faker->address,
                'no_telepon' => $faker->phoneNumber,
                'email_yayasan' => $faker->unique()->safeEmail,
                'website_yayasan' => $faker->url,
                'logo_yayasan' => 'images/logo/default.png',
                'deskripsi_yayasan' => $faker->sentence,
                'visi_yayasan' => $faker->sentence,
                'misi_yayasan' => $faker->sentence,
                'status_yayasan' => 'Aktif',
                'rating_yayasan' => '0.0',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
