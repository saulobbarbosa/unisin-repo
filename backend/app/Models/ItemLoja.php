<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemLoja extends Model
{
    use HasFactory;

    protected $table = 'itens_loja';
    protected $primaryKey = 'id_item_loja';
    public $timestamps = false;

    protected $fillable = [
        'nome',     // Novo campo
        'preco',
        'conteudo', 
        'tipo',     
    ];
}