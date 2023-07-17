<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventosModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'servico', 'prestador', 'data', 'filial', 'confirmacao', 'valor', 'confirmacao_pagamento'
    ];


}
