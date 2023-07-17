<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArquivaArquivosMidiaModel extends Model
{
    protected $table = 'arquiva_arquivos_midias';
    protected $primaryKey = 'id';
    protected $fillable=[
        'ArqCodigo',
        'url', 'nomeOri'
    ];


    public function arquivo(){
        return $this -> hasone('App\Models\ArquivaArquivosModel','ArqCodigo','ArqCodigo');
    }
}
