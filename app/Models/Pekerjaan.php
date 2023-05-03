<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'tgl',
        'id_jenis_pekerjaan',
        'keterangan',
        'fee',
        'status',
        'created_by',
    ]; 

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $table = 'pekerjaan';

    public function jenis_pekerjaan()
    {
        return $this->BelongsTo(JenisPekerjaan::class,'id_jenis_pekerjaan');
    }

    public function user()
    {
        return $this->BelongsTo(User::class,'id_user');
    }
}
