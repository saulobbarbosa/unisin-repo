<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opcao extends Model
{
    use HasFactory;

    protected $table = 'opcoes';

    protected $fillable = [
        'pergunta_id',
        'texto_opcao',
        'eh_correta',
    ];

    protected $casts = [
        'eh_correta' => 'boolean',
    ];

    public function pergunta()
    {
        return $this->belongsTo(Pergunta::class);
    }
}