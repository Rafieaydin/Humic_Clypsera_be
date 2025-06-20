<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddSukuPasien extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pasien = \App\Models\Pasien::all();
        $faker = \Faker\Factory::create();

        foreach ($pasien as $p) {
            $p->suku_pasien = $faker->randomElement([
                'Jawa',
                'Sunda',
                'Batak',
                'Minangkabau',
                'Bugis',
                'Bali',
                'Betawi',
                'Aceh',
                'Banten',
                'Madura']);
            $p->save();
        }
    }
}
