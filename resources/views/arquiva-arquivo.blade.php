<!DOCTYPE html>

<head>
    <title>Arquiva Arquivos</title>

    <style>
        .custom-file-upload {
            border: 1px solid #6b6b6b;
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 6px;
            background-color: #969696;
            color: #ffffff;
          }
          
          .custom-file-upload:hover {
            background-color: #6b6b6b;
          }
          
          .file-name {
            display: block;
            margin-top: 10px;
            font-size: 14px;
            color: #555;
          }
          
    </style>
</head>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Arquivar Arquivos') }}
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
                                    <p class="mb-30 ff-montserrat"></p>

                                    <form method="post" action="{{ route('salva_midias') }}" enctype="multipart/form-data" id="frm_multiplo">
                                        @csrf
                                        <div id="input-nome-ori"></div>
                                        <div class="mt-4">
                                            <label for="titulo">Título</label>
                                            <x-jet-input type="text" name="titulo" class="block mt-1 w-full" id="titulo"/>
                                            @error('titulo')
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                        
                                        <div class="mt-4">
                                            <label for="descricao">Descrição</label>
                                            <textarea id="descricao" name="descricao" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" name="descricao" cols="50" rows="2" id="descricao"></textarea>
                                            @error('descricao')
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>

                                        <div class="mt-4">
                                            <div class="mt-4">
                                                <label for="arquivo" class="custom-file-upload">Escolher Arquivos</label>
                                                <input type="file" name="arquivo[]" multiple class="form-input rounded-md shadow-sm mt-1 block w-full" id="arquivo" onchange="updateFileName()">
                                                @error('arquivo')
                                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                @enderror
                                                <div class="mt-2" id="fileList">
                                                    <span class="file-name"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <label for="arquivo2" class="custom-file-upload">Escolher Arquivos</label>
                                            <input type="file" name="arquivo2[]" multiple class="form-input rounded-md shadow-sm mt-1 block w-full" id="arquivo2" onchange="updateFileName2()">
                                            @error('arquivo2')
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $message }}</strong>
                                            @enderror
                                            <div class="mt-2" id="fileList2">
                                                <span class="file-name"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4">
                                            <label for="arquivo3" class="custom-file-upload">Escolher Arquivos</label>
                                            <input type="file" name="arquivo3[]" multiple class="form-input rounded-md shadow-sm mt-1 block w-full" id="arquivo3" onchange="updateFileName3()">
                                            @error('arquivo3')
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $message }}</strong>
                                            @enderror
                                            <div class="mt-2" id="fileList3">
                                                <span class="file-name"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4">
                                            <label for="arquivo4" class="custom-file-upload">Escolher Arquivos</label>
                                            <input type="file" name="arquivo4[]" multiple class="form-input rounded-md shadow-sm mt-1 block w-full" id="arquivo4" onchange="updateFileName4()">
                                            @error('arquivo4')
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $message }}</strong>
                                            @enderror
                                            <div class="mt-2" id="fileList4">
                                                <span class="file-name"></span>
                                            </div>
                                        </div>                                        

                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-lg  btn-primary" name="send" id="send">
                                                Enviar
                                            </button>
                                        </div>
                                    </form>
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
    function updateFileName() {
        let fileList = document.getElementById('arquivo').files;
        let fileListDiv = document.getElementById('fileList');
        fileListDiv.innerHTML = '';

        let inputNomeOri = document.getElementById('input-nome-ori');
        inputNomeOri.innerHTML = '';

        for (let i = 0; i < fileList.length; i++) {
            let fileName = document.createElement('span');
            fileName.innerHTML = fileList[i].name;
            fileName.classList.add('file-name');
            fileListDiv.appendChild(fileName);

            // Adicione o seguinte trecho de código abaixo do elemento "fileName"
            let inputNomeOriElement = document.createElement('input');
            inputNomeOriElement.type = 'hidden';
            inputNomeOriElement.name = 'nomeOri[]';
            inputNomeOriElement.value = fileList[i].name;
            inputNomeOri.appendChild(inputNomeOriElement);
        }
    }

    function updateFileName2() {
        let fileList = document.getElementById('arquivo2').files;
        let fileListDiv = document.getElementById('fileList2');
        fileListDiv.innerHTML = '';

        let inputNomeOri = document.getElementById('input-nome-ori');
        inputNomeOri.innerHTML = '';

        for (let i = 0; i < fileList.length; i++) {
            let fileName = document.createElement('span');
            fileName.innerHTML = fileList[i].name;
            fileName.classList.add('file-name');
            fileListDiv.appendChild(fileName);

            // Adicione o seguinte trecho de código abaixo do elemento "fileName"
            let inputNomeOriElement = document.createElement('input');
            inputNomeOriElement.type = 'hidden';
            inputNomeOriElement.name = 'nomeOri[]';
            inputNomeOriElement.value = fileList[i].name;
            inputNomeOri.appendChild(inputNomeOriElement);
        }
    }

    function updateFileName3() {
        let fileList = document.getElementById('arquivo3').files;
        let fileListDiv = document.getElementById('fileList3');
        fileListDiv.innerHTML = '';

        let inputNomeOri = document.getElementById('input-nome-ori');
        inputNomeOri.innerHTML = '';

        for (let i = 0; i < fileList.length; i++) {
            let fileName = document.createElement('span');
            fileName.innerHTML = fileList[i].name;
            fileName.classList.add('file-name');
            fileListDiv.appendChild(fileName);

            // Adicione o seguinte trecho de código abaixo do elemento "fileName"
            let inputNomeOriElement = document.createElement('input');
            inputNomeOriElement.type = 'hidden';
            inputNomeOriElement.name = 'nomeOri[]';
            inputNomeOriElement.value = fileList[i].name;
            inputNomeOri.appendChild(inputNomeOriElement);
        }
    }

    function updateFileName4() {
        let fileList = document.getElementById('arquivo4').files;
        let fileListDiv = document.getElementById('fileList4');
        fileListDiv.innerHTML = '';

        let inputNomeOri = document.getElementById('input-nome-ori');
        inputNomeOri.innerHTML = '';

        for (let i = 0; i < fileList.length; i++) {
            let fileName = document.createElement('span');
            fileName.innerHTML = fileList[i].name;
            fileName.classList.add('file-name');
            fileListDiv.appendChild(fileName);

            // Adicione o seguinte trecho de código abaixo do elemento "fileName"
            let inputNomeOriElement = document.createElement('input');
            inputNomeOriElement.type = 'hidden';
            inputNomeOriElement.name = 'nomeOri[]';
            inputNomeOriElement.value = fileList[i].name;
            inputNomeOri.appendChild(inputNomeOriElement);
        }
    }

</script>
  
  
