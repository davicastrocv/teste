<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    
</head>
<x-app-layout>
    <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mídias Arquivadas') }}
            </h2>
        </x-slot>
    
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
    
    
                <div class="container">
    
    
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <div class="career-search mb-60">
    
                            <form action="{{ route('midias_arquivadas_busca') }}" class="career-form mb-30" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-lg-3 my-3">
                                        <input type="text" class="form-control" name="titulo" placeholder="Título">
                                    </div>
                                    <div class="col-md-6 col-lg-3 my-3">
                                        <input type="text" class="form-control" name="descricao" placeholder="Descrição">
                                    </div>
                                    <div class="col-md-6 col-lg-3 my-3">
                                        <input type="text" class="form-control" name="nomeOri" placeholder="Arquivo">
                                    </div>
                                    <div class="col-md-6 col-lg-3 my-3">
                                        <button type="submit" class="btn btn-lg btn-block btn-light btn-custom" id="contact-submit">Buscar</button>
                                        <button type="submit" class="btn btn-lg btn-block btn-light btn-custom" id="contact-submit" onclick="location.href = '{{ route('midias_arquivadas_busca')}}'">Todos</button>
                                    </div>
                                </div>
                            </form>
                            
    
                            <div class="filter-result">
                                @if(count($objArquivo) > 0)
                                    <table class="table table-hover ff-montserrat align-items-center justify-content-between col-xs">
                                        <thead>
                                            <tr>
                                                <th scope="col">Título</th>
                                                <th scope="col">Descrição</th>
                                                <th scope="col">Data</th>
                                                <th scope="col">Hora</th>
                                                <th scope="col">Arquivos</th>
                                                <th scope="col"> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($objArquivo as $obj)
                                                <tr>
                                                    <td><span style="white-space:normal">{{$obj->Titulo}}</span></td>
                                                    <td><span style="white-space:normal">{{$obj->Descricao}}</span></td>
                                                    <td>{{ date('d/m/Y', strtotime($obj->created_at)) }}</td>
                                                    <td>{{ date('H:i:s', strtotime($obj->created_at)) }}</td>
                                                    <td class="d-flex">
                                                        <select class="form-select">
                                                            <option>Selecione o arquivo</option>
                                                            @foreach($obj->arquiva_midias as $objMidia)
                                                                <option value="{{asset('storage/'.$objMidia->url)}}" data-nome="{{ $objMidia->nomeOri }}">
                                                                    {{ $objMidia->nomeOri }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <button type="button" class="btn btn-sm btn-primary" onclick="downloadFile(this)">
                                                            <i class="bi bi-download"></i>
                                                        </button>
                                                    </td>
                                                    
                                                    <td>
                                                        <form method="POST" action="{{ route('midias_arquivadas_excluir', ['id' => $obj->ArqCodigo]) }}" onsubmit="return confirm('Tem certeza que deseja excluir essa pasta de arquivos?')">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">Excluir</button>
                                                        </form>
                                                    </td>                                                    
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="mb-30 ff-montserrat">Ops! Nenhum arquivo encontrado!</p>
                                @endif
                            </div>
                            
                            
    
    </x-app-layout>
    @if (session()->has('success'))
    
    <script> Swal.fire(
      'Arquivos enviados com Sucesso!',
      '',
      'success'
    )</script>

    @elseif (session()->has('deletado'))
    
    <script> Swal.fire(
        'Pasta de arquivos excluída com sucesso!',
        '',
        'deletado'
      )</script>
    @endif

    <script>
        function downloadFile(button) {
            var select = button.previousElementSibling;
            var option = select.options[select.selectedIndex];
            var url = option.value;
            var nome = option.getAttribute("data-nome");
            var link = document.createElement("a");
            link.download = nome;
            link.href = url;
            link.click();
        }

        function carregaArquivosPorFilial(fil, mes, ano) {
            $.ajax({
                type: 'get',
                url: "/recebidos/carrega_arquivos_cap",
                data: {
                    filial: fil,
                    mes: mes,
                    ano: ano
                },
                beforeSend: function() {
                    $('#collapse' + fil).html(
                        '<div class="d-flex flex-row justify-content-center align-items-center"><img src="/img/carregando2.gif" alt="carregando..."  width="50" height="50"><br></div> '
                        );
                },
                success: function(data) {
                    $('#collapse' + fil).html(data.html);
                },
                error: function() {
                    alert('Erro no Ajax de carregamento de arquivos !');
                }
            });
        }
    
        function forcaDownload(arq, arquivoMidia, codArquivo, arrayArquivos, codFilial) {
            //alert(arrayArquivos);
    
            var btn = '#btn_' + arquivoMidia;
            var link = 'a_' + arquivoMidia;
            var apelido = 'divFilApelido_' + codFilial;
    
            $.ajax({
                type: 'get',
                url: "/recebidos/marca_baixado",
                data: {
                    arquivoMidia: arquivoMidia,
                    arquivo: codArquivo,
                    arrayArquivos: arrayArquivos
                },
                success: function(data) {
                    if (data == 'sucesso') {
    
                        const element = document.querySelector(btn);
                        element.classList.remove('btn-warning');
                        element.classList.add('btn-success');
                        document.getElementById(link).click();
    
                    } else if (data == 'sucesso-todos-baixados') {
    
    
                        document.getElementById(apelido).className = "todos-lidos";
    
                        const element = document.querySelector(btn);
                        element.classList.remove('btn-warning');
                        element.classList.add('btn-success');
                        document.getElementById(link).click();
    
                    } else {
                        alert('Erro retorno ajax marca baixado');
                    }
                },
                error: function() {
                    alert('Erro no envio do Ajax marcando como baixado!');
                }
            });
    
        }
    </script>
