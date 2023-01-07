<?php

namespace Database\Seeders;

use App\Models\Jenis;
use Illuminate\Database\Seeder;

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // buat array list jenis insiden
        $jenis = [
            "Kebakaran",
            "Kecelakaan",
            "Pencurian",
            "Pembunuhan",
            "Pemerkosaan",
        ];
        // looping array list jenis insiden
        foreach ($jenis as $j) {
            $jenis = new Jenis();
            $jenis->nama = $j;
            $jenis->save();
        }
    }
}
