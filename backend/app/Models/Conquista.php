<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conquista extends Model
{
    use HasFactory;

    protected $table = 'conquistas';
    protected $primaryKey = 'id_conquista';
    public $timestamps = false;

    protected $fillable = [
        'nome_conquista',
    ];
}
