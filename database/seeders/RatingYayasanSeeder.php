<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingYayasanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        // Insert sample ratings for yayasan
        for ($i = 0; $i < 50; $i++) {
            DB::table('list_rating_yayasan')->insert([
                'yayasan_id' => rand(1, 10),
                'user_id' => rand(1, 20),
                'rating' => rand(1, 5),
                'komentar' => $faker->sentence,
                'tanggal_rating' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        // Update rating_yayasan in yayasan table based on average ratings
        $yayasanIds = DB::table('yayasan')->pluck('id');
        foreach ($yayasanIds as $yayasanId) {
            $averageRating = DB::table('list_rating_yayasan')
                ->where('yayasan_id', $yayasanId)
                ->avg('rating');

            DB::table('yayasan')
                ->where('id', $yayasanId)
                ->update(['rating_yayasan' => number_format($averageRating, 1)]);
        }
    }
}
