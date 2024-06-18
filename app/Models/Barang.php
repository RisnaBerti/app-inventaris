<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'barangs';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['nama_barang', 'kode_barang', 'merk_model', 'ukuran', 'bahan', 'tahun_pembuatan_pembelian', 'satuan', 'jml_barang'];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['nama_barang' => 'string', 'kode_barang' => 'string', 'merk_model' => 'string', 'ukuran' => 'string', 'bahan' => 'string', 'tahun_pembuatan_pembelian' => 'integer', 'satuan' => 'string', 'jml_barang' => 'integer', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    
    public function transaks()
    {
        return $this->hasMany(Transak::class);
    }

}
