<?php

namespace Database\Seeders;

use App\Models\Pasien;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PasienDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = \Spatie\Permission\Models\Role::where('guard_name', 'api')->where('name', 'operator')->first();
        $operator_id = \App\Models\User::whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role->name);
        })->select('id')->get()->pluck('id')->toArray();
        $operasi_id = \App\Models\Operasi::select('id')->get()->pluck('id')->toArray(); // luck sama select sama
        $faker = \Faker\Factory::create('id_ID');
        for ($i=1; $i <= 100 ; $i++) {
            Pasien::create([
                'nama_pasien' => $faker->name(),
                'tanggal_lahir' => $faker->dateTimeBetween('-20 years', '-10 year')->format('Y-m-d'),
                'umur_pasien' => $faker->numberBetween(10,20),
                'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                'alamat_pasien' => $faker->address(),
                'no_telepon' => "62".$faker->unique()->numerify('##########'),
                'pasien_anak_ke_berapa' => rand(1, 3),
                'kelainan_kotigental' => $faker->randomElement(['Tidak ada', 'Ada']),
                'riwayat_kehamilan' => $faker->randomElement(['Tidak ada', 'Ada']),
                'riwayat_keluarga_pasien' => $faker->randomElement(['Tidak ada', 'Ada']),
                'riwayat_kawin_kerabat' => $faker->randomElement(['Tidak ada', 'Ada']),
                'riwayat_terdahulu' => $faker->randomElement(['Tidak ada', 'Ada']),
                'operator_id' => $faker->randomElement($operator_id),
            ]);
        }


    }
}
