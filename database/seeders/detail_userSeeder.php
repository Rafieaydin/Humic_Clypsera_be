<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class detail_userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $user = User::all();

        foreach ($user as $value) {
            DB::table('detail_user')->insert([
                [
                    'nik' => $faker->unique()->numerify('##########'),  // generate nik
                    'user_id' => $value->id,
                    'pekerjaan' => $faker->randomElement(['Software Engineer', 'Dokter', 'Guru', 'Pengacara', 'Wiraswasta']),
                    'tanggal_lahir' => $faker->dateTimeBetween('-40 years', '-18 years')->format('Y-m-d'),
                    'umur' => $faker->numberBetween(18, 40),
                    'alamat' => $faker->address('id_ID'),
                    'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                    'no_telepon' => "62" . $faker->unique()->numerify('##########'),
                    'foto' => '/images/profile/default.png',
                ],
            ]);
        }

    }
}
