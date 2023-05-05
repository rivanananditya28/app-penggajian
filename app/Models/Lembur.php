<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    use HasFactory;

    protected $table = 'lembur';

    protected $connection = 'mysql';

    protected $fillable = [
        'start',
        'end',
        'id_user',
        'durasi',
        'fee',
        'type',
        'keterangan',
    ]; 

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->BelongsTo(User::class,'id_user');
    }

    public function type()
    {
        return $this->BelongsTo(JenisPekerjaan::class,'type');
    }


}
