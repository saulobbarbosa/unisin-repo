<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;
    
    protected $table = 'alunos';
    protected $primaryKey = 'id_usuario';
    public $incrementing = false; 
    public $timestamps = false;
    protected $keyType = 'int';

    protected $fillable = [
        'id_usuario',
        'moedas',
        'avatar',
        'borda',
        'fundo'
    ];

    // Relacionamento com usuário
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    // Relacionamento com Perguntas (Muitos para Muitos)
    public function perguntas()
    {
        return $this->belongsToMany(Pergunta::class, 'alunos_has_perguntas', 'aluno_id_usuario', 'pergunta_id')
                    ->withPivot('status')
                    ->withTimestamps();
    }
}