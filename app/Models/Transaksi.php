<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transaksis';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['barang_id', 'ruangan_id', 'tgl_mutasi', 'tahun_akademik', 'jenis_mutasi', 'jml_mutasi', 'periode', 'tampat_asal'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['tgl_mutasi' => 'date:d/m/Y', 'tahun_akademik' => 'string', 'jml_mutasi' => 'integer', 'periode' => 'date:m/Y', 'tampat_asal' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    

	public function barang()
	{
		return $this->belongsTo(\App\Models\Barang::class);
	}	
	public function ruangan()
	{
		return $this->belongsTo(\App\Models\Ruangan::class);
	}
}
