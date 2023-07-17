<?php

use App\Http\Controllers\ArquivaArquivosController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecebidosController;
use App\Http\Controllers\FiliaisController;
use App\Http\Controllers\EnviadosController;
use App\Http\Controllers\FullCalenderController;
use App\Http\Controllers\MidiasArquivadasController;
use App\Http\Controllers\PermissaoController;
use Illuminate\Support\Facades\Auth;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/register',[Controller::class , 'registro_user'])->name('register');
Route::get('/teste',[Controller::class , 'teste']);






Route::middleware(['auth:sanctum', 'verified']) -> post('/enviados/busca',                [EnviadosController::class, 'index'])->name('busca_enviados');
Route::middleware(['auth:sanctum', 'verified']) -> get('/enviar',                         [RecebidosController::class , 'enviar'])->name('enviar');
Route::middleware(['auth:sanctum', 'verified']) -> get('/enviados',                       [EnviadosController::class, 'index'])->name('enviados');
Route::middleware(['auth:sanctum', 'verified']) -> get('/recebidos',                      [RecebidosController::class, 'index'])->name('index');
Route::middleware(['auth:sanctum', 'verified']) -> match(['get', 'post'], '/recebidos/contas-a-pagar',       [RecebidosController::class, 'index_cap'])->name('index_cap');
Route::middleware(['auth:sanctum', 'verified']) -> match(['get', 'post'],'/recebidos/financeiro',           [RecebidosController::class, 'index_financeiro'])->name('index_financeiro');
Route::middleware(['auth:sanctum', 'verified']) -> post('/envio-acao',                    [RecebidosController::class , 'store'])->name('envio-acao');//UPLOAD DE ARQUIVOS
Route::middleware(['auth:sanctum', 'verified']) -> post('/recebidos/busca',               [RecebidosController::class , 'index'])->name('busca_recebidos');//BUSCA DE RECEBIDOS
Route::middleware(['auth:sanctum', 'verified']) -> get('/recebidos/carrega_arquivos',     [RecebidosController::class , 'carrega_arquivos'])->name('carrega_arquivos');// AJAX CARREGAR ARQUIVOS
Route::middleware(['auth:sanctum', 'verified']) -> get('/recebidos/carrega_arquivos_cap',     [RecebidosController::class , 'carrega_arquivos_cap'])->name('carrega_arquivos_cap');// AJAX CARREGAR ARQUIVOS
Route::middleware(['auth:sanctum', 'verified']) -> get('/recebidos/carrega_arquivos_financeiro',     [RecebidosController::class , 'carrega_arquivos_financeiro'])->name('carrega_arquivos_financeiro');// AJAX CARREGAR ARQUIVOS
Route::middleware(['auth:sanctum', 'verified']) -> get('/recebidos/marca_baixado',        [RecebidosController::class , 'marca_baixado'])->name('marca_baixado');// AJAX MARCA BAIXADO


Route::middleware(['auth:sanctum', 'verified']) ->match(['get', 'post'], '/enviar/arquiva_arquivo', [ArquivaArquivosController::class, 'index'])->name('arquiva_arquivo');

Route::middleware(['auth:sanctum', 'verified']) ->match(['get', 'post'],'/midias',        [ArquivaArquivosController::class, 'store'])->name('salva_midias');

Route::middleware(['auth:sanctum', 'verified']) ->post('/mensagem_aviso',                 [ArquivaArquivosController::class, 'show'])->name('mensagem_aviso'); 

Route::middleware(['auth:sanctum', 'verified']) ->match(['get', 'post'],'/midias_arquivadas',  [MidiasArquivadasController::class, 'index'])->name('midias_arquivadas');

Route::middleware(['auth:sanctum', 'verified']) ->post('midias_arquivadas/busca',         [MidiasArquivadasController::class, 'index'])->name('midias_arquivadas_busca');
Route::middleware(['auth:sanctum', 'verified']) ->post('midias_arquivadas/delete/{id}', [MidiasArquivadasController::class, 'delete'])->name('midias_arquivadas_excluir');

Route:: get('/seta-permissao',  [PermissaoController::class, 'set'])->name('seta-permissao');
Route::get('/recebidos',[RecebidosController::class, 'index'])->name('recebidos')->middleware('auth');
Route::get('/recebidos/contas-a-pagar',[RecebidosController::class, 'index_cap'])->name('index_cap')->middleware('auth');
Route::get('/recebidos/financeiro',[RecebidosController::class, 'index_financeiro'])->name('index_financeiro')->middleware('auth');

Route::get('/recebidos/agenda-pagamentos',[RecebidosController::class, 'index_ap'])->name('index_ap')->middleware('auth');

Route::match(['get', 'post'],'fullcalender', [FullCalenderController::class, 'index'])->name('index_agenda');
Route::post('fullcalenderAjax', [FullCalenderController::class, 'ajax']);






