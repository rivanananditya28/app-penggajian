<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPekerjaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nominal',
    ]; 

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $table = 'jenis_pekerjaan';

}
