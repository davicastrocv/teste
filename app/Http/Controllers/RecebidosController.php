<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\RecebidoModel;
use App\Models\FilialModel;
use App\Models\ArquivoModel;
use App\Models\ArquivoMidiaModel;
use DB;

class RecebidosController extends Controller
{

    private $objFiliais;
    private $objArquivo;
    private $objArqMidias;



    public function __construct(){
       $this ->  objFiliais = new FilialModel();
       $this ->  objArquivo = new ArquivoModel();
       $this ->  objArqMidias = new ArquivoMidiaModel();

    }

    public function marca_baixado(Request $resquest){
        $retorno = 'sucesso';

        $this -> objArqMidias
                        -> where('ArqMidCodigo','=',$resquest -> arquivoMidia)
                        -> update(['ArqMidBaixado'=>true]);

       //VERIFICA SE OS ARQUIVSO ESTÃO BAIXADOS PAR ATROCAR A COR DO CSS
       $objArqMidias = $this -> objArqMidias
                                    -> whereIn('ArqCodigo', explode(',',$resquest -> arrayArquivos))
                                    -> whereNull('ArqMidBaixado')
                                    -> count();
        if($objArqMidias==0) {
            $retorno = 'sucesso-todos-baixados';
        }

        return $retorno;

    }




    public function carrega_arquivos(Request $resquest){



        $objArquivo =  $this-> objArquivo
                                -> join('filiais', 'filiais.filCodigo', '=','arquivos.ArqCodRemetente' )
                                -> where('ArqCodDestinatario',auth()->user()->filCodigo )
                                -> where ('ArqCodRemetente', $resquest -> filial )
                                -> whereYear ('arquivos.ArqData', $resquest -> ano)
                                -> whereMonth ('arquivos.ArqData',$resquest -> mes)
                                -> with(['arquivosMidias','destinatario'])
                                -> orderby('ArqData','desc')
                                -> get();

        $view = view('ajax-carrega-arquivos',[
            'objArquivo' => $objArquivo])->render();


         return response()->json(['html'=>$view]);
        }
    
    public function carrega_arquivos_cap(Request $resquest){



        $objArquivo =  $this-> objArquivo
                                -> join('filiais', 'filiais.filCodigo', '=','arquivos.ArqCodRemetente' )
                                -> where('ArqCodDestinatario',103 )
                                -> where ('ArqCodRemetente', $resquest -> filial )
                                -> whereYear ('arquivos.ArqData', $resquest -> ano)
                                -> whereMonth ('arquivos.ArqData',$resquest -> mes)
                                -> with(['arquivosMidias','destinatario'])
                                -> orderby('ArqData','desc')
                                -> get();

        $view = view('ajax-carrega-arquivos',[
            'objArquivo' => $objArquivo])->render();


            return response()->json(['html'=>$view]);
        }
    public function carrega_arquivos_financeiro(Request $resquest){



        $objArquivo =  $this-> objArquivo
                                -> join('filiais', 'filiais.filCodigo', '=','arquivos.ArqCodRemetente' )
                                -> where('ArqCodDestinatario',101 )
                                -> where ('ArqCodRemetente', $resquest -> filial )
                                -> whereYear ('arquivos.ArqData', $resquest -> ano)
                                -> whereMonth ('arquivos.ArqData',$resquest -> mes)
                                -> with(['arquivosMidias','destinatario'])
                                -> orderby('ArqData','desc')
                                -> get();

        $view = view('ajax-carrega-arquivos',[
            'objArquivo' => $objArquivo])->render();


            return response()->json(['html'=>$view]);
        }

    public function index(Request $request){



        $selectFiliais = $this-> objFiliais->orderby('filCodigo')-> get();

        $mesAtual = (is_numeric($request->meses))?$request->meses: date('m');
        $anoAtual = (is_numeric($request->ano))?$request->ano: date('Y');
        $filial   = (is_numeric($request->filial))?$request->filial:false;

        //dd( $mesAtual."/".$anoAtual);

        $sql = ' select * from (select distinct  a."ArqCodRemetente" as "codRemetente",f."filApelido" as apelido,f."filCodigo" as "codFilial",
                (    SELECT max(aa."ArqData") from arquivos aa
                    where aa."ArqCodRemetente" = a."ArqCodRemetente"
                     and aa."ArqCodDestinatario" =  '.auth()->user()->filCodigo.'
                         and  EXTRACT(YEAR  from aa."ArqData" ) = '.$anoAtual.'
                         and EXTRACT(MONTH  from aa."ArqData" ) = '.$mesAtual.'
                    limit 1
                ) as data
                from arquivos as a
                inner join filiais  f on f."filCodigo" =  a."ArqCodRemetente"
                where EXTRACT(YEAR  from a."ArqData" ) = '.$anoAtual.'
                and EXTRACT(MONTH  from a."ArqData" ) = '.$mesAtual.'
                and a."ArqCodDestinatario" =  '.auth()->user()->filCodigo;
                if($filial){
                    $sql .=' and a."ArqCodRemetente" = '.$filial;
                }
                $sql .= ' ) t order by data desc ';

                 // echo $sql;
                //  dd(' ');
        $obFilDistintas = DB::select($sql);


        //////////// RETORNA CODIGO DA FILIAL BAIXADAS PARA ESSE FILTRO//////////////////

            $controleBaixados= array();
            foreach($obFilDistintas as $objFilDist){

               // SEM BAIXAR RETORNA > 0
               // TODOS BAIXADOS RETONA 0
               $sql = 'select count(*) as qtd  from arquivos_midias where "ArqCodigo" in(select "ArqCodigo" from arquivos
               where  "ArqCodRemetente" = '.$objFilDist->codFilial;
               if($filial){
                   $sql.=' and "ArqCodRemetente" = '.$filial;
               }
               $sql.=' and  EXTRACT(MONTH FROM "ArqData") = '.$mesAtual;
               $sql.=' and  EXTRACT(YEAR FROM "ArqData") = '.$anoAtual;
               $sql.=' and "ArqCodDestinatario" = '.auth()->user()->filCodigo;
               $sql.=') and "ArqMidBaixado" is null ';
               $obj = DB::select($sql);

                if($obj[0]->qtd==0) {
                        $controleBaixados[] =$objFilDist->codFilial;
                }
            }



        /////////////////////////////////////////////////////////////////

            //dd($obFilDistintas);
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

        return view('recebidos', [
            'selectFiliais' => $selectFiliais,
            'obFilDistintas' => $obFilDistintas,
            'objMeses' => $meses,
            'mesAtualBusca'=>$mesAtual,
            'anoAtualBusca'=> $anoAtual,
            'FilialBusca'=>$filial,
            'controleBaixados'=>$controleBaixados
        ]);
    }
    
    public function index_cap(Request $request){

        

        $selectFiliais = $this-> objFiliais->orderby('filCodigo')-> get();

        $mesAtual = (is_numeric($request->meses))?$request->meses: date('m');
        $anoAtual = (is_numeric($request->ano))?$request->ano: date('Y');
        $filial   = (is_numeric($request->filial))?$request->filial:false;

        //dd( $mesAtual."/".$anoAtual);

        $sql = ' select * from (select distinct  a."ArqCodRemetente" as "codRemetente",f."filApelido" as apelido,f."filCodigo" as "codFilial",
                (    SELECT max(aa."ArqData") from arquivos aa
                    where aa."ArqCodRemetente" = a."ArqCodRemetente"
                     and aa."ArqCodDestinatario" =  103
                         and  EXTRACT(YEAR  from aa."ArqData" ) = '.$anoAtual.'
                         and EXTRACT(MONTH  from aa."ArqData" ) = '.$mesAtual.'
                    limit 1
                ) as data
                from arquivos as a
                inner join filiais  f on f."filCodigo" =  a."ArqCodRemetente"
                where EXTRACT(YEAR  from a."ArqData" ) = '.$anoAtual.'
                and EXTRACT(MONTH  from a."ArqData" ) = '.$mesAtual.'
                and a."ArqCodDestinatario" =  103';
                if($filial){
                    $sql .=' and a."ArqCodRemetente" = '.$filial;
                }
                $sql .= ' ) t order by data desc ';

                 // echo $sql;
                //  dd(' ');
        $obFilDistintas = DB::select($sql);


        //////////// RETORNA CODIGO DA FILIAL BAIXADAS PARA ESSE FILTRO//////////////////

            $controleBaixados= array();
            foreach($obFilDistintas as $objFilDist){

               // SEM BAIXAR RETORNA > 0
               // TODOS BAIXADOS RETONA 0
               $sql = 'select count(*) as qtd  from arquivos_midias where "ArqCodigo" in(select "ArqCodigo" from arquivos
               where  "ArqCodRemetente" = '.$objFilDist->codFilial;
               if($filial){
                   $sql.=' and "ArqCodRemetente" = '.$filial;
               }
               $sql.=' and  EXTRACT(MONTH FROM "ArqData") = '.$mesAtual;
               $sql.=' and  EXTRACT(YEAR FROM "ArqData") = '.$anoAtual;
               $sql.=' and "ArqCodDestinatario" = 103';
               $sql.=') and "ArqMidBaixado" is null ';
               $obj = DB::select($sql);

                if($obj[0]->qtd==0) {
                        $controleBaixados[] =$objFilDist->codFilial;
                }
            }



        /////////////////////////////////////////////////////////////////

            //dd($obFilDistintas);
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

        return view('recebidos-cap', [
            'selectFiliais' => $selectFiliais,
            'obFilDistintas' => $obFilDistintas,
            'objMeses' => $meses,
            'mesAtualBusca'=>$mesAtual,
            'anoAtualBusca'=> $anoAtual,
            'FilialBusca'=>$filial,
            'controleBaixados'=>$controleBaixados
        ]);
    }

    
    public function index_financeiro(Request $request){



        $selectFiliais = $this-> objFiliais->orderby('filCodigo')-> get();

        $mesAtual = (is_numeric($request->meses))?$request->meses: date('m');
        $anoAtual = (is_numeric($request->ano))?$request->ano: date('Y');
        $filial   = (is_numeric($request->filial))?$request->filial:false;

        //dd( $mesAtual."/".$anoAtual);

        $sql = ' select * from (select distinct  a."ArqCodRemetente" as "codRemetente",f."filApelido" as apelido,f."filCodigo" as "codFilial",
                (    SELECT max(aa."ArqData") from arquivos aa
                    where aa."ArqCodRemetente" = a."ArqCodRemetente"
                     and aa."ArqCodDestinatario" =  101
                         and  EXTRACT(YEAR  from aa."ArqData" ) = '.$anoAtual.'
                         and EXTRACT(MONTH  from aa."ArqData" ) = '.$mesAtual.'
                    limit 1
                ) as data
                from arquivos as a
                inner join filiais  f on f."filCodigo" =  a."ArqCodRemetente"
                where EXTRACT(YEAR  from a."ArqData" ) = '.$anoAtual.'
                and EXTRACT(MONTH  from a."ArqData" ) = '.$mesAtual.'
                and a."ArqCodDestinatario" =  101';
                if($filial){
                    $sql .=' and a."ArqCodRemetente" = '.$filial;
                }
                $sql .= ' ) t order by data desc ';

                 // echo $sql;
                //  dd(' ');
        $obFilDistintas = DB::select($sql);


        //////////// RETORNA CODIGO DA FILIAL BAIXADAS PARA ESSE FILTRO//////////////////

            $controleBaixados= array();
            foreach($obFilDistintas as $objFilDist){

               // SEM BAIXAR RETORNA > 0
               // TODOS BAIXADOS RETONA 0
               $sql = 'select count(*) as qtd  from arquivos_midias where "ArqCodigo" in(select "ArqCodigo" from arquivos
               where  "ArqCodRemetente" = '.$objFilDist->codFilial;
               if($filial){
                   $sql.=' and "ArqCodRemetente" = '.$filial;
               }
               $sql.=' and  EXTRACT(MONTH FROM "ArqData") = '.$mesAtual;
               $sql.=' and  EXTRACT(YEAR FROM "ArqData") = '.$anoAtual;
               $sql.=' and "ArqCodDestinatario" = 101';
               $sql.=') and "ArqMidBaixado" is null ';
               $obj = DB::select($sql);

                if($obj[0]->qtd==0) {
                        $controleBaixados[] =$objFilDist->codFilial;
                }
            }



        /////////////////////////////////////////////////////////////////

            //dd($obFilDistintas);
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

        return view('recebidos-financeiro', [
            'selectFiliais' => $selectFiliais,
            'obFilDistintas' => $obFilDistintas,
            'objMeses' => $meses,
            'mesAtualBusca'=>$mesAtual,
            'anoAtualBusca'=> $anoAtual,
            'FilialBusca'=>$filial,
            'controleBaixados'=>$controleBaixados
        ]);
    }
    
    public function enviar()    {

        $filiais = FilialModel::where('filRecArquivo', '1')->get();
        return view('enviar', [
            'filiais' => $filiais
        ]);
    }

    public function store(Request $request) {

        // BLOCO DE VALIDAÇÃO DAS ESTENSÕES DO ARQUIVO



        $extensaoPermitida = 'jpg|jpeg|pdf|doc|docx|gif|xls|xlx|ods';

        // $request->validate([
        //     'file' => 'required|mimes:png,jpg,jpeg,csv,txt,xlx,xls,pdf|max:2048'
        //     ]);


        $pasta ='public/arquivos/'.auth()->user()->filCodigo;


        if(trim($request -> file1)!=''){
            $img01Nome = md5(time() . rand(0, 9999) . time()).'.'. $request->arquivo1->extension();
            $img01 =  $request->arquivo1->storeAs($pasta,$img01Nome );
        }else{
            $img01 = '';
        }
        if(trim($request -> file2)!=''){
            $img02Nome = md5(time() . rand(0, 9999) . time()).'.'. $request->arquivo2->extension();
            $img02 =  $request->arquivo2->storeAs($pasta,$img02Nome);
        }else{
            $img02 = '';
        }
        if(trim($request -> file3)!=''){
            $img03Nome = md5(time() . rand(0, 9999) . time()) .'.'. $request->arquivo3->extension();
           $img03 =  $request->arquivo3->storeAs($pasta,$img03Nome);
        }else{
            $img03 = '';
        }
        if(trim($request -> file4)!=''){
           $img04Nome = md5(time() . rand(0, 9999) . time()) .'.'. $request->arquivo4->extension();
           $img04 =  $request->arquivo4->storeAs($pasta,$img04Nome);
        }else{
            $img04 = '';
        }


        $arq = ArquivoModel::create([
            'ArqTitulo' =>  $request-> titulo,
            'ArqDescricao' => $request -> descricao,
            'ArqBaixado' => 0,
            'AqrAtivo' => 1,
            'ArqCodRemetente' =>auth()->user()->filCodigo,
            'ArqCodDestinatario'=> $request -> departamento,
            'ArqData'=> now(),
            'UseId'=> auth()->user()->id
        ]);



        $chave = $arq-> ArqCodigo;


            if(trim($img01)){
                $this -> objArqMidias -> create(['ArqMidArquivo'=> str_replace('public','',$img01), 'ArqCodigo'=>$chave]);
            }
            if(trim($img02)){
                $this -> objArqMidias -> create(['ArqMidArquivo'=> str_replace('public','',$img02), 'ArqCodigo'=>$chave]);
            }
            if(trim($img03)){
                $this -> objArqMidias -> create(['ArqMidArquivo'=> str_replace('public','',$img03), 'ArqCodigo'=>$chave]);
            }
            if(trim($img04)){
                $this -> objArqMidias -> create(['ArqMidArquivo'=> str_replace('public','',$img04), 'ArqCodigo'=>$chave]);
            }


       return redirect('enviados')->with('success', true);
    }

}
