<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    protected $table = 'professores';
    protected $primaryKey = 'id_usuario';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'escola_id_escola',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function escola()
    {
        return $this->belongsTo(Escola::class, 'escola_id_escola');
    }

    public function perguntas()
    {
        return $this->hasMany(Pergunta::class, 'professor_id_usuario');
    }
}