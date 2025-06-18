<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperasiDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $role = \Spatie\Permission\Models\Role::where('guard_name','api')->where('name', 'operator')->first();
        $operator_id = \App\Models\User::whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role->name);
        })->select('id')->get()->pluck('id')->toArray();
        for ($i = 1; $i <= 100; $i++) {
            DB::table('operasi')->insert([
                [
                    'diagnosis_id' => 1,
                    'jenis_terapi_id' => 1,
                    'jenis_kelainan_cleft_id' => 1,
                    'tanggal_operasi' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                    'tehnik_operasi' => $faker->randomElement([
                        'Operasi Bibir Sumbing',
                        'Operasi Langit-langit Sumbing',
                        'Operasi Kombinasi Bibir dan Langit-langit Sumbing'
                    ]),
                    'nama_penyelenggara' => $faker->company,
                    'lokasi_operasi' => $faker->randomElement([
                        'RS Cleft Care',
                        'RS Sumbing Indonesia',
                        'RS Cleft Center'
                    ]),
                    'foto_sebelum_operasi' => '/images/data_pasien/default.png',
                    'foto_setelah_operasi' => '/images/data_pasien/default.png',
                    'follow_up' => $faker->randomElement([
                        'Follow up 1 bulan setelah operasi',
                        'Follow up 3 bulan setelah operasi',
                        'Follow up 6 bulan setelah operasi'
                    ]),
                    'operator_id' => $faker->randomElement($operator_id),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'pasien_id' => $i
                ]
            ]);
        }
    }
}
