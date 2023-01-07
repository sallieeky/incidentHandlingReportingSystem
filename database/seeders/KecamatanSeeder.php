<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = Http::get('http://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota=9105');
        $data = $data->json();
        $kecamatans = $data["kecamatan"];
        foreach ($kecamatans as $kecamatan) {
            $nm = $kecamatan["nama"];
            $dt_kecamatan = \App\Models\Kecamatan::create([
                "nama" => $nm
            ]);
            $data = Http::get('http://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan=' . $kecamatan["id"]);
            $data = $data->json();
            $kelurahans = $data["kelurahan"];
            foreach ($kelurahans as $kelurahan) {
                $kelurahan = $kelurahan["nama"];
                \App\Models\Kelurahan::create([
                    "kecamatan_id" => $dt_kecamatan->id,
                    "nama" => $kelurahan
                ]);
            }
        }
    }
}
