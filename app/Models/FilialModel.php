<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilialModel extends Model
{
    protected $table = 'filiais';
    protected $primaryKey = 'filCodigo';
    protected $fillable=[

                'filCodigo',
                'filName',
                'filRecArquivo',
                'filApelido'

       ];
    use HasFactory;
}
