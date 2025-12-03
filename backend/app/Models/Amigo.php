<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amigo extends Model
{
    use HasFactory;

    protected $table = 'amigos';
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = null;

    protected $fillable = [
        'aluno_id_usuario1',
        'aluno_id_usuario2',
    ];

    public function aluno1()
    {
        return $this->belongsTo(Aluno::class, 'aluno_id_usuario1');
    }

    public function aluno2()
    {
        return $this->belongsTo(Aluno::class, 'aluno_id_usuario2');
    }
}
