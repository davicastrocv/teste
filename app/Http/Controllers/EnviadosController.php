<?php

namespace App\Http\Controllers;

use App\Models\EnviadoModel;
use Illuminate\Http\Request;
use App\Models\FilialModel;
use App\Models\ArquivoModel;
use DB;

class EnviadosController extends Controller
{
    public function __construct(){
        $this ->  objFiliais = new FilialModel();
        $this ->  objArquivo = new ArquivoModel();
     }

    public function index(Request $request)
    {

        $mesAtual = (is_numeric($request->meses))?$request->meses: date('m');
        $anoAtual = (is_numeric($request->ano))?$request->ano: date('Y');
        $filial   = (is_numeric($request->filial))?$request->filial:'';
        $selectFiliais = $this-> objFiliais-> all();

        $meses = [
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        ];


         $objArquivos = $this -> objArquivo
                            -> select('f.*','a.*')
                            -> from('arquivos as  a')
                            -> join('filiais as f','f.filCodigo', '=','a.ArqCodRemetente')
                            -> where('a.ArqCodRemetente','=',auth()->user()->filCodigo)
                            -> whereYear('a.ArqData',$anoAtual)
                            -> whereMonth('a.ArqData',$mesAtual)
                            -> with(['arquivosMidias','destinatario'])
                            -> orderby('a.ArqData', 'desc')
                            -> get();



        return view('enviados', [
            'selectFiliais' => $selectFiliais,
            'objArquivo' => $objArquivos,
            'objMeses' => $meses,
            'mesAtualBusca'=>$mesAtual,
            'anoAtualBusca'=> $anoAtual,
            'FilialBusca'=>$filial
        ]);

    }


}
