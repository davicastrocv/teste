<?php

namespace App\Http\Controllers;

use App\Models\ArquivaArquivosMidiaModel;
use App\Models\ArquivaArquivosModel;
use App\Models\EnviadoModel;
use Illuminate\Http\Request;
use App\Models\FilialModel;
use App\Models\ArquivoModel;
use DB;
use Illuminate\Support\Facades\Storage;

class MidiasArquivadasController extends Controller
{
    public function __construct(){
        //$this ->  objFiliais = new FilialModel();
        $this ->  objArquivo = new ArquivaArquivosModel();
     }

    public function index(Request $request)
    {

        //$mesAtual = (is_numeric($request->meses))?$request->meses: date('m');
        //$anoAtual = (is_numeric($request->ano))?$request->ano: date('Y');
        //$filial   = (is_numeric($request->filial))?$request->filial:'';
        //$selectFiliais = $this-> objFiliais-> all();

        $titulo = $request->input('titulo');
        $descricao = $request->input('descricao');
        $nomeOri = $request->input('nomeOri');

        // $meses = [
        //     '01' => 'Janeiro',
        //     '02' => 'Fevereiro',
        //     '03' => 'Março',
        //     '04' => 'Abril',
        //     '05' => 'Maio',
        //     '06' => 'Junho',
        //     '07' => 'Julho',
        //     '08' => 'Agosto',
        //     '09' => 'Setembro',
        //     '10' => 'Outubro',
        //     '11' => 'Novembro',
        //     '12' => 'Dezembro'
        // ];
        

        $objArquivos = $this->objArquivo
            ->select('aa.*')
            ->from('arquiva_arquivos as aa')
            ->where('aa.Chave', '=', 'F')
            ->whereIn('aa.ArqCodigo', function ($query) use ($nomeOri) {
                $query->select('aam.ArqCodigo')
                    ->from('arquiva_arquivos_midias as aam')
                    ->join('arquiva_arquivos as aa', 'aam.ArqCodigo', '=', 'aa.ArqCodigo')
                    ->where('aam.nomeOri', 'ILIKE', '%' . $nomeOri . '%');
            })
            ->where(function ($query) use ($titulo, $descricao) {
                if (!empty($titulo)) {
                    $query->where('aa.Titulo', 'LIKE', '%' . $titulo . '%');
                }
        
                if (!empty($descricao)) {
                    $query->orWhere('aa.Descricao', 'LIKE', '%' . $descricao . '%');
                }
            })
            ->with(['arquiva_midias'])
            ->get();
        
        
        
        //dd($objArquivos);


        return view('midias-arquivadas', [
            'objArquivo' => $objArquivos,
            // 'objMeses' => $meses,
            // 'mesAtualBusca'=>$mesAtual,
            // 'anoAtualBusca'=> $anoAtual
        ]);

    }

    

    public function delete($id)
    {
        $midiaArquivada = ArquivaArquivosMidiaModel::where('ArqCodigo', $id)->get();
        
        //dd(asset('storage/midias'));

        foreach($midiaArquivada as $arquivo) {
            $file = storage_path() . '/app/public/'.$arquivo->url;
        
            if (!file_exists($file)) {
                abort(404);
            }
            unlink($file);
            // $pasta ='public/midias';
            // $caminho_arquivo = storage_path($pasta . $arquivo->url);
            // unlink($caminho_arquivo);
            //Storage::delete('C:\Laravel\malote2\storage\app\public\midias' . $arquivo->url);
        }

        ArquivaArquivosModel::where('ArqCodigo', $id)->delete();
        return redirect()->back()->with('deletado', true);

    }


}
