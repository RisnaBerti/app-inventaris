<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pegawais';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id', 
        'jabatan', 
        'no_tlpn', 
        'alamat', 
        // 'jenis_jenjang',
        'nama_sekolah',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = [
        'jabatan' => 'string', 
        'no_tlpn' => 'string', 
        'alamat' => 'string', 
        'nama_sekolah' => 'string',
        'created_at' => 'datetime:d/m/Y H:i', 
        'updated_at' => 'datetime:d/m/Y H:i'
    ];
    

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

    public function jenjang()
    {
        return $this->belongsTo(\App\Models\Jenjang::class);
    }
}
