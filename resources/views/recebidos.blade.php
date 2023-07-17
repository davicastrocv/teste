<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">


                <div class="container">


                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                            <div class="career-search mb-60">

                                <form action="{{ route('busca_recebidos') }}" class="career-form mb-30" method="POST">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-6 col-lg-3 my-3">
                                            <div class="select-container">


                                                <select class="custom-select" id="meses" name="meses">
                                                    <option selected="">Mês</option>

                                                    @foreach ($objMeses as $chave => $texto)
                                                        <option value="{{ $chave }}"
                                                            {{ $selecionado = $chave == $mesAtualBusca ? 'selected' : '' }}>
                                                            {{ $texto }}</option>
                                                    @endforeach
                                                </select>


                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-3 my-3">
                                            <div class="select-container">


                                                <select class="custom-select" id="ano" name="ano">
                                                    <option selected="">Ano</option>

                                                    @for ($i = date('Y'); $i >= date('Y') - 10; $i--)
                                                        <option value="{{ $i }}"
                                                            {{ $i == $anoAtualBusca ? 'selected' : '' }}>
                                                            {{ $i }} </option>
                                                    @endfor

                                                </select>



                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3 my-3">
                                            <div class="select-container">


                                                <select class="custom-select" id="filial" name="filial">
                                                    <option selected="">Filial Remetente</option>
                                                    @foreach ($selectFiliais as $fil)
                                                        <option value="{{ $fil->filCodigo }}"
                                                            {{ $fil->filCodigo == $FilialBusca ? 'selected' : '' }}>
                                                            {{ $fil->filName }}</option>
                                                    @endforeach

                                                </select>


                                            </div>
                                        </div>


                                        <div class="col-md-6 col-lg-3 my-3">
                                            <button type="submit" class="btn btn-lg btn-block btn-light btn-custom "
                                                id="contact-submit">
                                                Busca
                                            </button>
                                            <button type="button" class="btn btn-lg  btn-light" id="contact-submit"
                                                onclick="location.href = '{{ route('recebidos') }}'">
                                                Todos
                                            </button>
                                        </div>
                                    </div>
                                </form>



                                <div class="filter-result">

                                    @if (count($obFilDistintas) > 0)
                                        @foreach ($obFilDistintas as $objFilDist)
                                            <div class="job-box d-md-flex align-items-center justify-content-between mb-30"
                                                id="accordionExample{{ $objFilDist->codFilial }}">
                                                <div class="job-left my-4 d-md-flex align-items-center flex-wrap">
                                                    <div class="{{ in_array($objFilDist->codFilial, $controleBaixados) ? 'todos-lidos' : 'nao-lidos' }}"
                                                        id="divFilApelido_{{ $objFilDist->codFilial }}"
                                                        name="divFilApelido_{{ $objFilDist->codFilial }}">
                                                        {{ $objFilDist->apelido }}
                                                    </div>
                                                    <div class="job-content">
                                                        <ul class="d-md-flex flex-wrap  ff-open-sans">
                                                            <li class="mr-md-4">
                                                                <i class="zmdi zmdi-money mr-2"></i>
                                                            </li>
                                                            <li class="mr-md-4">
                                                                <i class="zmdi zmdi-time mr-2"></i>último envio em
                                                                {{ date('d/m/Y H:i:s', strtotime($objFilDist->data)) }}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="job-right my-4 flex-shrink-0">
                                                    <button
                                                        onclick="carregaArquivosPorFilial('{{ $objFilDist->codFilial }}','{{ $mesAtualBusca }}','{{ $anoAtualBusca }}');"
                                                        class="btn btn-outline-info" type="button"
                                                        data-toggle="collapse"
                                                        data-target="#collapse{{ $objFilDist->codFilial }}"
                                                        aria-expanded="false"
                                                        aria-controls="collapse{{ $objFilDist->codFilial }}">
                                                        abrir
                                                    </button>
                                                </div>
                                            </div>
                                            <div id="collapse{{ $objFilDist->codFilial }}" class="collapse"
                                                aria-labelledby="heading{{ $objFilDist->codFilial }}"
                                                data-parent="#accordionExample{{ $objFilDist->codFilial }}">
                                                <div class="d-flex flex-row justify-content-center align-items-center">
                                                    <img src="/img/carregando2.gif" alt="carregando..." width="50"
                                                        height="50"><br></div>

                                            </div>
                                        @endforeach
                                    @else
                                        <p class="mb-30 ff-montserrat">Ops! Nenhum arquivo encontrado!</p>
                                    @endif


                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

</x-app-layout>
<script>
    function carregaArquivosPorFilial(fil, mes, ano) {
        $.ajax({
            type: 'get',
            url: "/recebidos/carrega_arquivos",
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
