<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FilialModel;
use Session;
use DB;

class PermissaoController extends Controller
{

    private $objFiliais;


    public function __construct(){

       $this ->  objFiliais = new FilialModel();

    }
    public function set(){
        
        //session_start();

        session()->flush('recebeArquivo');//REMOVE A SESSÃO

        $obj = $this-> objFiliais
                        -> select('filRecArquivo')
                        -> where('filCodigo',auth()->user()->filCodigo)
                        ->get();        
                        
        if($obj[0]->filRecArquivo){
            session()->put('recebeArquivo', 1);//RECEVE ARQUIVOS            
          // return  redirect()->route('recebidos');

        }else{
            session()->put('recebeArquivo', 0);// NÃO RECEBE ARQUIVOS       
            //return redirect()->route('enviados');
            return redirect('/recebidos');
        }


    }
}
