<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->integer("instansi_id"); // id instansi yang menangani kejadian
            $table->integer("kecamatan_id");
            $table->integer("kelurahan_id");
            $table->integer("jenis_id");
            $table->string("lat");
            $table->string("lng");
            $table->dateTime("waktu_kejadian");
            $table->dateTime("waktu_penanganan")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidents');
    }
}
