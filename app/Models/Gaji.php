<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gaji';

    protected $fillable = [
        'nominal',
        'tahun',
    ]; 

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
