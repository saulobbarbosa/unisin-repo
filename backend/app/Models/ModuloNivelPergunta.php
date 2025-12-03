<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuloNivelPergunta extends Model
{
    use HasFactory;

    protected $table = 'modulo_nivel_perguntas';

    protected $fillable = [
        'modulo_ensino_id',
        'nivel_id',
        'pergunta_id',
    ];

    public function modulo()
    {
        return $this->belongsTo(ModuloEnsino::class, 'modulo_ensino_id', 'id_modulo_ensino');
    }

    public function nivel()
    {
        return $this->belongsTo(Nivel::class, 'nivel_id');
    }

    public function pergunta()
    {
        return $this->belongsTo(Pergunta::class, 'pergunta_id');
    }
}