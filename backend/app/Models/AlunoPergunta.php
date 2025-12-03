<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlunoPergunta extends Model
{
    use HasFactory;

    protected $table = 'alunos_has_perguntas';

    // A tabela NÃO tem ID automático
    public $incrementing = false;

    // Define que a chave é composta
    protected $primaryKey = ['aluno_id_usuario', 'pergunta_id'];

    protected $fillable = [
        'aluno_id_usuario',
        'pergunta_id',
        'status',
    ];

    protected function setKeysForSaveQuery($query)
    {
        // Laravel usa esse método para montar o WHERE da atualização
        return $query
            ->where('aluno_id_usuario', '=', $this->getAttribute('aluno_id_usuario'))
            ->where('pergunta_id', '=', $this->getAttribute('pergunta_id'));
    }

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'aluno_id_usuario');
    }

    public function pergunta()
    {
        return $this->belongsTo(Pergunta::class, 'pergunta_id');
    }
}
