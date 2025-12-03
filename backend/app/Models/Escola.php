<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escola extends Model
{
    use HasFactory;

    protected $table = 'escolas';
    protected $primaryKey = 'id_escola';
    public $timestamps = false; // a tabela não tem created_at/updated_at

    protected $fillable = [
        'nome',
        'cep',
        'rua',
        'cidade',
        'estado',
        'id_usuario',
    ];

    // Relacionamento
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
