<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Enviar Arquivos') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">


                <div class="container">


                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                            <div class="career-search mb-60">




                                <div class="filter-result">
                                    <p class="mb-30 ff-montserrat">


                                    </p>



                                    <div class="job-box d-md-flex align-items-center justify-content-between mb-30"
                                        id="accordionExample">
                                        <div class="job-left my-4 d-md-flex align-items-center flex-wrap">
                                            <form method="post" enctype="multipart/form-data"
                                                action="{{ route('envio-acao') }}" id="basic-form" name="basic-form" >
                                                @csrf
                                                <div>
                                                    <x-jet-label for="departamento"
                                                        value="{{ __('Enviar para:') }}" />
                                                    <select name="departamento" id="departamento"
                                                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                                                        <option value="">selecione</option>
                                                        @foreach ($filiais as $fil)
                                                            <option value="{{ $fil->filCodigo }}">{{ $fil->filName }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>

                                                <div class="mt-4">
                                                    <x-jet-label for="titulo" value="{{ __('Titulo') }}" />
                                                    <x-jet-input id="titulo" class="block mt-1 w-full" type="text"
                                                        name="titulo" />
                                                </div>
                                                <div class="mt-4">
                                                    <x-jet-label for="titulo" value="{{ __('Descrição') }}" />

                                                    <textarea id="descricao" name="descricao"
                                                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full"
                                                        name="placeOfDeath" cols="50" rows="2" id="placeOfDeath"></textarea>
                                                </div>
                                                <div class="mt-4">
                                                    <x-jet-label for="titulo" value="Selecione até 4 arquivos" />
                                                </div>
                                                @for ($i = 1; $i <= 4; $i++)
                                                    <div class="mt-4">
                                                        <input type="file" name="arquivo{{ $i }}"
                                                            id="arquivo{{ $i }}" class="arquivo">
                                                        <input type="button" class="btn  btn-secondary"
                                                            value="SELECIONAR" id="btn1"
                                                            onclick="clickUp('{{ $i }}');">
                                                        <input type="text" name="file{{ $i }}"
                                                            id="file{{ $i }}" readonly="readonly"
                                                            class="border-gray-300 rounded-md shadow-sm mt-1 mx-auto">
                                                    </div>
                                                @endfor
                                                <div class="mt-4"> </div>
                                                <button type="submit" class="btn btn-lg  btn-primary" name="send" id="send">
                                                    Enviar
                                                </button>
                                    </div>

                                </div>



                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

</x-app-layout>
<script>
    // DESABILITA O BOTÃO DE ENVIO PARA TERMOS VARIOS ENVIOS REPETIDOS////


    // var formID = document.getElementById("basic-form");
    // var send = $("#send");

    // $(formID).submit(function(event) {
    //     if (formID.checkValidity()) {
    //         send.attr('disabled', 'disabled');
    //     }
    // });



    <?php $extensao = 'jpg|jpeg|pdf|doc|docx|png|gif|xls|xlx|ods|tif|tiff'; ?>

    function clickUp(id) {


        $('#arquivo' + id).trigger('click');

        $('#arquivo' + id).on('change', function() {
            var fileName = $(this)[0].files[0].name;

            $('#file' + id).val(fileName);
        });

    }


    var validator = $("#basic-form").validate({
        errorElement: "span",
        errorClass: "error",
        rules: {
            departamento: "required",
            titulo: "required",
            file1: {
                required: true,
                extension: "<?php echo $extensao; ?>"
            },
            file2: {
                required: false,
                extension: "<?php echo $extensao; ?>"
            },
            file3: {
                required: false,
                extension: "<?php echo $extensao; ?>"
            },
            file4: {
                required: false,
                extension: "<?php echo $extensao; ?>"
            }
        },
        messages: {
            departamento: "Preencha o campo Departamento",
            titulo: "Preencha o campo Titulo",
            file1: {
                required: "<br>Selecione pelo menos 1 arquivo",
                extension: "<br>Arquivo com extensão inválida!"

            },
            file2: {

                extension: "<br>Arquivo com extensão inválida!"

            },
            file3: {

                extension: "<br>Arquivo com extensão inválida!"

            },
            file4: {

                extension: "<br>Arquivo com extensão inválida!"

            }
        }
    });
    // $("#send").removeAttr('disabled');
   //$("#send").attr('disabled', 'disabled');
</script>
