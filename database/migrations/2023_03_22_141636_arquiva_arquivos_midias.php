<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArquivaArquivosMidias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arquiva_arquivos_midias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ArqCodigo');
            $table->string('url');
            $table->foreign('ArqCodigo')->references('ArqCodigo')->on('arquiva_arquivos')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('arquiva_arquivos_midias');
    }
}
