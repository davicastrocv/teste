<table class="table table-hover ff-montserrat align-items-center justify-content-between col-xs">
                                <thead >
                                    <tr>
                                    <th scope="col">Ttulo</th>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Hora</th>
                                    <th scope="col">Destinatario</th>
                                    <th scope="col">Download</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                  // GERA ARRAY COM CODIGO DOS ARQUIVOS DESSA FILIAL.
                                  $arrayArqFil = '';
                                  foreach($objArquivo as $obj){
                                    $arrayArqFil .= $obj->ArqCodigo.',';
                                  }
                                  $arrayArqFil=substr($arrayArqFil,0,-1);
                                  ?>
                                    @foreach($objArquivo as $obj)

                                    <tr>
                                         <td ><span  style="white-space:normal">{{$obj->ArqTitulo}}</span></td>
                                         <td ><span  style="white-space:normal">{{$obj->ArqDescricao}}</span></td>
                                         <td>{{ date('d/m/Y', strtotime($obj->ArqData)) }}</td>
                                         <td>{{ date('H:i:s', strtotime($obj->ArqData))  }}</td>
                                         <td>{{$obj->destinatario->filName}}</td>

                                         <td>
                                         <?php $i=1; ?>

                                        @foreach($obj -> arquivosMidias  as $objMidia)
                                          @if(trim($objMidia->ArqMidArquivo)!='')
                                          <a

                                          id="a_{{$objMidia->ArqMidCodigo}}"
                                          name="a_{{$objMidia->ArqMidCodigo}}"

                                          href="{{  asset('storage/'.$objMidia->ArqMidArquivo)}}" download="{{  asset('storage/'.$objMidia->ArqMidArquivo)}}"></a>
                                          <button type="button" class="btn {{($objMidia-> ArqMidBaixado)?'btn-success':'btn-warning'}} btn-space"

                                            onclick="forcaDownload('{{  asset('storage/'.$objMidia->ArqMidArquivo)}}','{{$objMidia->ArqMidCodigo}}', '{{$obj->ArqCodigo}}','{{$arrayArqFil}}','{{$obj->ArqCodRemetente}}')"

                                            id="btn_{{$objMidia->ArqMidCodigo}}" name="btn_{{$objMidia->ArqMidCodigo}}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                          <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                          <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                                        </svg>0{{$i}}</button>
                                          @endif
                                        <?php $i++ ?>
                                        @endforeach


                                    </tr>
                                    @endforeach
                                </tbody>
                                </table><br>
