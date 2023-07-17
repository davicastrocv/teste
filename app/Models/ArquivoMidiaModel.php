<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArquivoMidiaModel extends Model
{
    use HasFactory;
    protected $table = 'arquivos_midias';
    protected $primaryKey = 'ArqMidCodigo';

    protected $fillable=['ArqMidCodigo','ArqMidArquivo','ArqMidBaixado','ArqCodigo','ArqCodigo'];

    public function arquivo(){
        return $this -> hasOne('App\Modoles\RecebidosController');
    }



}

