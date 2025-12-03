<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlunoConquista extends Model
{
    use HasFactory;

    protected $table = 'alunos_has_conquistas';
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = null;

    protected $fillable = [
        'aluno_id_usuario',
        'conquista_id_conquista',
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'aluno_id_usuario');
    }

    public function conquista()
    {
        return $this->belongsTo(Conquista::class, 'conquista_id_conquista');
    }
}
