<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    protected $appends = ["format_kejadian", "format_penanganan"];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }
    public function jenis()
    {
        return $this->belongsTo(Jenis::class);
    }

    public function getFormatKejadianAttribute()
    {
        return date("D, d-m-Y H:i", strtotime($this->waktu_kejadian));
    }
    public function getFormatPenangananAttribute()
    {
        return date("D, d-m-Y H:i", strtotime($this->waktu_penanganan));
    }
}
