<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\SeguirController;
use App\Http\Controllers\SolicitacaoController;


Route::post('/notifications/mark-as-read', [MainController::class, 'markAllAsRead'])->name('notifications.markAllAsRead')->middleware('login');


//login
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login/process', [LoginController::class, 'process'])->name('process');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/register/process', [LoginController::class, 'registerDado'])->name('register.dado');

//seguir
Route::get('/follow/user/{id}', [SeguirController::class, 'seguir'])->name('seguir')->middleware('login');
Route::get('/unfollow/user/{id}', [SeguirController::class, 'deixarSeguir'])->name('deixar.seguir')->middleware('login');

//solicitação
Route::get('/request/{perfilId}', [SolicitacaoController::class, 'solicitacao'])->name('request')->middleware('login');
Route::get('/cancel/{id}', [SolicitacaoController::class, 'deleteSolicitacao'])->name('request.delete')->middleware('login');
Route::get('/accepted/{id}/{userId}', [SolicitacaoController::class, 'solicitacaoAceita'])->name('request.accepted')->middleware('login');

//email
Route::get('/email/verify/{token}/{username}', [LoginController::class, 'verificarEmail'])->name('verificarEmail');


//redirect
Route::get('/', [MainController::class, 'redirect'])->name('redirect')->middleware('login');

//explorar
Route::get('/explore', [Maincontroller::class, 'explorar'])->name('explorar')->middleware('login');
Route::get('/search', [MainController::class, 'search'])->name('search');



//perfil
Route::get('/user/{username}', [MainController::class, 'perfil'])->name('perfil');
Route::get('/user/edit/{username}', [MainController::class, 'edtPerfil'])->name('edt.perfil')->middleware('login');
Route::put('/user/editing/{id}', [PerfilController::class, 'editandoPerfil'])->name('editando')->middleware('login');

//post
Route::get('/post/{id}', [MainController::class, 'showPost'])->name('show.post');
Route::get('/post/remove/{id}', [MainController::class, 'removePost'])->name('remove.post')->middleware('login');


//add.fotos
Route::get('/addfoto', [PostController::class, 'addFotos'])->name('addfoto')->middleware('login');
Route::post('/addfoto/process', [PostController::class, 'capturandoFoto'])->name('processfoto')->middleware('login');


//comentario
Route::get('/remove/comment/{idPost}/{idComment}', [ComentarioController::class, 'removeComment'])->name('remove.comentario')->middleware('login');
Route::post('/add/comment', [ComentarioController::class, 'addComentario'])->name('add.comentario')->middleware('login');
