<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Model
{
    use HasFactory, HasApiTokens;

    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nome',
        'dt_nasc',
        'email',
        'senha',
        'telefone',
    ];
}
