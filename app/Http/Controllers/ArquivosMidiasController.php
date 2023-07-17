<?php

namespace App\Http\Controllers;

use App\Models\ArquivoMidiaModel;
use Illuminate\Http\Request;
use DB;


class ArquivosMidiasController extends Controller
{

   
    private $objArqMidias;

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this-> objArqMidia -> create([
            'ArqMidArquivo' => $request -> img,
            'ArqCodigo' => $request -> arqCodigo
        ]);
        return true;
        
    }

   
}
