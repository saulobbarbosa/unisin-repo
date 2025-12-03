<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuloEnsino extends Model
{
    use HasFactory;

    protected $table = 'modulos_ensino';
    protected $primaryKey = 'id_modulo_ensino';
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'nivel',
    ];

    // Relação: Módulo tem muitas Perguntas
    public function perguntas()
    {
        return $this->hasMany(Pergunta::class, 'modulo_ensino_id', 'id_modulo_ensino');
    }
}