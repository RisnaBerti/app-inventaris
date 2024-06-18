<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelaporan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pelaporans';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['transak_id', 'no_inventaris', 'jml_baik', 'jml_kurang_baik', 'jml_rusak_berat', 'jml_hilang', 'keterangan'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['no_inventaris' => 'string', 'jml_baik' => 'integer', 'jml_kurang_baik' => 'integer', 'jml_rusak_berat' => 'integer', 'jml_hilang' => 'integer', 'keterangan' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    

	public function barang()
	{
		return $this->belongsTo(\App\Models\Barang::class);
	}	
	public function ruangan()
	{
		return $this->belongsTo(\App\Models\Ruangan::class);
	}	
	public function transak()
	{
		return $this->belongsTo(\App\Models\Transak::class);
	}
}
