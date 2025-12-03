<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlunoModuloEnsino extends Model
{
    use HasFactory;

    protected $table = 'alunos_has_modulos_ensino';
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = null; // Chave composta

    protected $fillable = [
        'aluno_id_usuario',
        'modulo_ensino_id_modulo_ensino',
        'nivel_id', // Novo campo
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'aluno_id_usuario', 'id_usuario');
    }

    public function moduloEnsino()
    {
        return $this->belongsTo(ModuloEnsino::class, 'modulo_ensino_id_modulo_ensino', 'id_modulo_ensino');
    }

    public function nivel()
    {
        return $this->belongsTo(Nivel::class, 'nivel_id', 'id');
    }
}