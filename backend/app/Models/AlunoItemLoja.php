<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlunoItemLoja extends Model
{
    use HasFactory;

    protected $table = 'alunos_has_itens_loja';
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = null;

    protected $fillable = [
        'aluno_id_usuario',
        'item_loja_id_item_loja',
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'aluno_id_usuario');
    }

    public function itemLoja()
    {
        return $this->belongsTo(ItemLoja::class, 'item_loja_id_item_loja');
    }
}
