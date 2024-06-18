<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mutasis';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['barang_id', 'ruangan_id', 'tgl_mutasi', 'jenis_mutasi', 'tahun_akademik', 'jml_mutasi', 'tempat_asal'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['tgl_mutasi' => 'date:d/m/Y', 'tahun_akademik' => 'string', 'jml_mutasi' => 'integer', 'tempat_asal' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    

	public function barang()
	{
		return $this->belongsTo(\App\Models\Barang::class);
	}	
	public function ruangan()
	{
		return $this->belongsTo(\App\Models\Ruangan::class);
	}
}
