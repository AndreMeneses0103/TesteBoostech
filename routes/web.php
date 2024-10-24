<?php

use App\Http\Controllers\PessoaController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/sorteio', function () {
    return view('sorteio');
});

Route::get('/cadastro/{id?}', function () {
    return view('cadastro');
});

Route::get('pessoas/all', [PessoaController::class, 'allUsers']);
Route::get('pessoas/resultado', [PessoaController::class, 'getSorteioResultados']);
Route::get('pessoas/resultado/{id}', [PessoaController::class, 'getSorteioResultadoPorId']);
Route::get('pessoas/{id}', [PessoaController::class, 'getPessoa']);
Route::post('pessoas/new', [PessoaController::class, 'createPessoa']);
Route::post('pessoas/sorteio', [PessoaController::class, 'sorteio']);
Route::patch('pessoas/update/{id}', [PessoaController::class, 'updatePessoa']);


Route::post('pessoas/login', [PessoaController::class, 'loginPessoa']);

Route::delete('pessoas/delete/{id}', [PessoaController::class, 'deletePessoa']);

