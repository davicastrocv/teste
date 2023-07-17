<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArquivoModel extends Model
{
   protected $table = 'arquivos';
   protected $primaryKey = 'ArqCodigo';
   protected $fillable=[
            'ArqTitulo',
            'ArqDescricao',
            'ArqBaixado',
            'AqrAtivo' ,
            'ArqCodRemetente',
            'ArqCodDestinatario',
            'ArqData',
            'ArqCodigo',
            'UseId'
   ];

   public function arquivosMidias(){
      return $this -> hasMany('App\Models\ArquivoMidiaModel','ArqCodigo','ArqCodigo');
  }
  public function destinatario(){
    return $this -> hasone(FilialModel::class,'filCodigo','ArqCodDestinatario');
 }


}
