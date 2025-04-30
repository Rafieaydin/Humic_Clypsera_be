<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        for ($i=0; $i < 10 ; $i++) {
            Berita::create([
                'judul' => $faker->sentence(3),
                'slug' => $faker->slug(),
                'gambar' => $faker->imageUrl(640, 480, 'animals', true),
                'content' => $faker->paragraph(5),
                'sumber' => $faker->url(),
                'status' => $faker->randomElement(['draft', 'published']),
                'user_id' => \App\Models\User::factory()->create()->id,
            ]);
        }
    }
}
