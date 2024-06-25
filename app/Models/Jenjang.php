<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenjang extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jenjangs';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'kode_jenjang', 
        'nama_jenjang',
        'foto_jenjang',
        'nama_sekolah'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = ['kode_jenjang' => 'string', 'nama_jenjang' => 'string', 'created_at' => 'datetime:d/m/Y H:i', 'updated_at' => 'datetime:d/m/Y H:i'];
    

    public function ruangan()
    {
        return $this->hasMany(Ruangan::class);
    }
}
