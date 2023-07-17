
<x-app-layout>
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Arquivos Enviados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">


            <div class="container">


            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="career-search mb-60">

                        <form action="{{ route('busca_enviados') }}" class="career-form mb-30" method="POST">
                        @csrf
                            <div class="row">

                                <div class="col-md-6 col-lg-3 my-3">
                                    <div class="select-container">


                                        <select class="custom-select" id="meses" name="meses">
                                            <option selected="">Mês</option>

                                            @foreach($objMeses as $chave =>$texto)

                                                <option value="{{$chave}}" {{   $selecionado = ($chave == $mesAtualBusca) ? 'selected' : ''}}>{{$texto}}</option>
                                            @endforeach
                                        </select>


                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-3 my-3">
                                    <div class="select-container">


                                        <select class="custom-select" id="ano" name="ano">
                                            <option selected="">Ano</option>

                                            @for ($i = date('Y'); $i >= date('Y')-10; $i--)
                                                <option value="{{ $i }}" {{ $i ==$anoAtualBusca ? 'selected' : ''  }}> {{ $i }} </option>
                                            @endfor

                                        </select>



                                    </div>
                                </div>



                                <div class="col-md-6 col-lg-3 my-3">
                                    <button type="submit" class="btn btn-lg btn-block btn-light btn-custom " id="contact-submit">
                                        Busca
                                    </button>
                                    <button type="button" class="btn btn-lg btn-block btn-light btn-custom " id="contact-submit" onclick="location.href = '{{ route('enviados')}}'">
                                        Todos
                                    </button>
                                </div>
                            </div>
                        </form>



                        <div class="filter-result">
                        @if(count($objArquivo) > 0)

                        <table class="table table-hover ff-montserrat align-items-center justify-content-between col-xs">
                                <thead >
                                    <tr>
                                    <th scope="col">Ttulo</th>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Hora</th>
                                    <th scope="col">Dest.</th>

                                    <th scope="col">Download</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($objArquivo as $obj)
                                    <tr>
                                         <td ><span  style="white-space:normal">{{$obj->ArqTitulo}}</span></td>
                                         <td ><span  style="white-space:normal">{{$obj->ArqDescricao}}</span></td>
                                         <td>{{ date('d/m/Y', strtotime($obj->ArqData)) }}</td>
                                         <td>{{ date('H:i:s', strtotime($obj->ArqData))  }}</td>
                                         <td>{{ $obj->destinatario ->filName }}</td>

                                         <td>
                                         <?php $i=1 ?>
                                         @foreach($obj -> arquivosMidias  as $objMidia)
                                          @if(trim($objMidia->ArqMidCodigo)!='')
                                          <a id="a_{{$objMidia->ArqMidCodigo}}_1" name="a_{{$objMidia->ArqMidCodigo}}_1"  href="{{  asset('storage/'.$objMidia->ArqMidArquivo)}}" download="{{  asset('storage/'.$objMidia->ArqMidArquivo)}}"></a>
                                          <button type="button" class="btn {{($objMidia-> ArqMidBaixado)?'btn-success':'btn-warning'}} btn-space" onclick="document.getElementById('a_{{$objMidia->ArqMidCodigo}}_1').click()" id="btn_{{$objMidia->ArqMidCodigo}}_1" name="btn_{{$objMidia->ArqMidCodigo}}_1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                          <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                          <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                                        </svg>{{$i}}</button>
                                          @endif
                                          <?php $i++ ?>
                                         @endforeach

                                    </tr>
                                    @endforeach



                                </tbody>
                                </table><br>
                                @else
                            <p class="mb-30 ff-montserrat">Ops! Nenhum arquivo encontrado!</p>
                            @endif

</x-app-layout>
@if (session()->has('success'))

<script> Swal.fire(
  'Arquivos enviados com Sucesso!',
  '',
  'success'
)</script>


@endif



<script>




