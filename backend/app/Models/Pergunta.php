<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pergunta extends Model
{
    use HasFactory;

    protected $table = 'perguntas';
    
    protected $fillable = [
        'enunciado',
        'tipo',
        'professor_id_usuario',
        // 'modulo_ensino_id' REMOVIDO
    ];

    public function professor()
    {
        return $this->belongsTo(Professor::class, 'professor_id_usuario');
    }

    // Relação para acessar a tabela pivô (Módulo e Nível)
    public function contexto()
    {
        return $this->hasOne(ModuloNivelPergunta::class, 'pergunta_id');
    }

    public function opcoes()
    {
        return $this->hasMany(Opcao::class, 'pergunta_id');
    }
    
    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'alunos_has_perguntas', 'pergunta_id', 'aluno_id_usuario')
                    ->withPivot('status')
                    ->withTimestamps();
    }
}