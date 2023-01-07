<?php

namespace Database\Seeders;

use App\Models\Incident;
use App\Models\Instansi;
use App\Models\Jenis;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Database\Seeder;

class IncidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenis = Jenis::all();
        $kecamatan = Kecamatan::all();
        $kelurahan = Kelurahan::all();
        $instansi = Instansi::all();

        for ($i = 0; $i < 100; $i++) {
            $incident = new Incident();
            $incident->jenis_id = $jenis->random()->id;
            $incident->kecamatan_id = $kecamatan->random()->id;
            $incident->kelurahan_id = $kelurahan->random()->id;
            $incident->instansi_id = $instansi->random()->id;
            $incident->lat = (rand(850000, 861453) / 1000000) * -1;
            $incident->lng = rand(134062, 136000) / 1000;
            $incident->waktu_kejadian = now()->subDays(rand(16, 30))->subHours(rand(1, 24))->subMinutes(rand(1, 60));
            $incident->waktu_penanganan = now()->subDays(rand(1, 15))->subHours(rand(1, 24))->subMinutes(rand(1, 60));
            $incident->save();
        }
    }
}
