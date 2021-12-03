<?php

namespace Database\Seeders;

use App\Models\Instansi;
use Illuminate\Database\Seeder;

class InstansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Instansi::create([
            'nama' => 'Instansi 1',
            'alamat' => 'Jl. Alamat 1',
        ]);
        Instansi::create([
            'nama' => 'Instansi 2',
            'alamat' => 'Jl. Alamat 2',
        ]);
        Instansi::create([
            'nama' => 'Instansi 3',
            'alamat' => 'Jl. Alamat 3',
        ]);
        Instansi::create([
            'nama' => 'Instansi 4',
            'alamat' => 'Jl. Alamat 4',
            "jumlah_penanganan" => 10,
        ]);
        Instansi::create([
            'nama' => 'Instansi 5',
            'alamat' => 'Jl. Alamat 5',
        ]);
    }
}
