<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArquivaArquivosModel extends Model
{
    protected $table = 'arquiva_arquivos';
    protected $primaryKey = 'ArqCodigo';
    protected $fillable=[
        'Titulo',
        'Descricao',
        'Chave'
    ];


    public function arquiva_midias(){
        return $this -> hasMany('App\Models\ArquivaArquivosMidiaModel','ArqCodigo','ArqCodigo');
    }
}
