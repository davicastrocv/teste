<?php

namespace App\Http\Controllers;

use App\Models\ArquivaArquivosMidiaModel;
use App\Models\ArquivaArquivosModel;
use App\Models\ArquivoMidiaModel;
use ArquivaArquivosMidias;
use Illuminate\Http\Request;
use Validator;


class ArquivaArquivosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('arquiva-arquivo');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $camposValidador = [
            'titulo' => 'required',
            'descricao' => 'required',
            'arquivo' => 'required'
        ];

        $validator = Validator::make($request->all(), $camposValidador);
        if ($validator->passes()) {

            $arquivo = new ArquivaArquivosModel();

            if (isset($request->titulo)) {
                $arquivo->Titulo = $request->titulo;
            }

            if (isset($request->descricao)) {
                $arquivo->Descricao = $request->descricao;
            }

            $arquivo->Chave = 'F';
            //dd($request->all());
            $arquivo->save();


            $arquivos = [];

            if (!empty($request->file('arquivo'))) {
                $arquivos = array_merge($arquivos, array_filter($request->file('arquivo')));
            }

            if (!empty($request->file('arquivo2'))) {
                $arquivos = array_merge($arquivos, array_filter($request->file('arquivo2')));
            }

            if (!empty($request->file('arquivo3'))) {
                $arquivos = array_merge($arquivos, array_filter($request->file('arquivo3')));
            }

            if (!empty($request->file('arquivo4'))) {
                $arquivos = array_merge($arquivos, array_filter($request->file('arquivo4')));
            }

            // foreach ($arquivos as $file) {
            //     $arquivomidia = new ArquivaArquivosMidiaModel(); 
            //     $arquivomidia->ArqCodigo = $arquivo->ArqCodigo;
            //     $pasta ='midias';
            //     $arquivomidia->url = $file->store($pasta);
            //     $arquivomidia->nomeOri = $file->getClientOriginalName();
            //     //dd ($arquivomidia->url);
            //     $arquivomidia->save();
            //     unset($arquivomidia);
            // }

            foreach ($arquivos as $file) {
                $nome = uniqid() . '.' . $file->extension();
                $img =  $file->storeAs('public/midias', $nome);
                ArquivaArquivosMidiaModel::create(
                    [
                        'url' => str_replace('public/','',$img),
                        'ArqCodigo' => $arquivo->ArqCodigo,
                        'nomeOri' => $file->getClientOriginalName()
                    ]
                );
              
            }
            return redirect()->route('midias_arquivadas')->with('success', true);
        } else {
            return back()->withErrors($validator)->withInput();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        ini_set('upload_max_filesize', '5M');
        header('Content-Type: application/json');
        dd('oi');
        $file = $request->file('file');

        $ret = [];

        if ($file->move('uploads/', $file->getClientOriginalName())) {
            $ret["status"] = "success";
            $ret["path"] = 'uploads/' . $file->getClientOriginalName();
            $ret["name"] = $file->getClientOriginalName();
        } else {
            $ret["status"] = "error";
            $ret["name"] = $file->getClientOriginalName();
        }

        echo json_encode($ret, JSON_PRETTY_PRINT);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
