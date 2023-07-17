<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArquivosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'arquivos';

    /**
     * Run the migrations.
     * @table arquivos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('ArqCodigo');
            $table->string('ArqTitulo')->nullable();
            $table->text('ArqDescricao')->nullable();
            $table->tinyInteger('ArqBaixado')->nullable();
            $table->tinyInteger('AqrAtivo')->nullable();
            $table->integer('ArqCodRemetente')->nullable();
            $table->integer('ArqCodDestinatario')->nullable();
            $table->dateTime('ArqData')->nullable();
            $table->integer('UseId')->nullable();
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
        Schema::dropIfExists($this->tableName);
    }
}
