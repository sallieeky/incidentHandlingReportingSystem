<?php

namespace Database\Seeders;

use App\Models\Wilayah;
use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Wilayah::create([
            "nama" => "Kabupaten 1",
        ]);
        Wilayah::create([
            "nama" => "Kabupaten 2",
        ]);
        Wilayah::create([
            "nama" => "Kabupaten 3",
        ]);
        Wilayah::create([
            "nama" => "Kabupaten 4",
        ]);
        Wilayah::create([
            "nama" => "Kabupaten 5",
        ]);
        Wilayah::create([
            "nama" => "Kabupaten 6",
        ]);
        Wilayah::create([
            "nama" => "Kabupaten 7",
        ]);
        Wilayah::create([
            "nama" => "Kabupaten 8",
        ]);
        Wilayah::create([
            "nama" => "Kabupaten 9",
        ]);
        Wilayah::create([
            "nama" => "Kabupaten 10",
        ]);
    }
}
