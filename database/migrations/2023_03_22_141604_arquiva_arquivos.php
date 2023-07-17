<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArquivaArquivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arquiva_arquivos', function (Blueprint $table) {
            $table->bigIncrements('ArqCodigo');
            $table->string('Titulo');
            $table->string('Descricao');
            $table->char('Chave')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arquiva_arquivos');
    }
}
