<?php

use Lib\Route;
use App\Controllers\HomeController;
use App\Controllers\UsuarioController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;

// Indicaremos la clase del controlador y el método a ejecutar. Solo algunas rutas están implementadas
// Tendremos rutas para get y pst, así como parámetros opcionales indicados con : que podrán
// ser recuperados por un mismo controlador. Por ejemplo, /curso/:variable y /curso/ruta1 usan el mismo controlador
// y :variable se trata como un parámetro ajeno a la ruta

// Ruta Inicial
Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);

// Crear Base de datos y registrar 100 usuarios
Route::get('/crearBD', [UsuarioController::class, 'create']);

//Login y cerrar sesion por método get
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login/check', [LoginController::class, 'check']);
Route::get('/logout', [LoginController::class, 'logout']);

//Envio a la pagina registro por método post y validación y registro
Route::get('/registro', [RegisterController::class, 'index']);
Route::post('/register/check', [RegisterController::class, 'check']);

//Gestion de usuario propio
Route::get('/usuario/:id', [UsuarioController::class, 'show']); //abrimos el panel de usuario
Route::post('/usuario/panel/:id', [UsuarioController::class, 'updateSelf']);
Route::post('/usuario/transaccion/:id', [UsuarioController::class, 'transaccion']);//Transaccion de Saldo

//Gestion de usuarios
Route::get('/usuarios', [UsuarioController::class, 'listar']); //listamos usuarios
Route::get('/usuarios/editar/:id', [UsuarioController::class, 'edit']); //abrimos el panel de usuario para multiples usuarios
Route::post('/usuarios/update/:id', [UsuarioController::class, 'updateOther']);
Route::get('/usuarios/delete/:id', [UsuarioController::class, 'delete']);

Route::get('/usuariosFiltrados', [UsuarioController::class, 'buscarUsuarios']);
Route::post('/usuariosFiltrados', [UsuarioController::class, 'buscarUsuarios']);


Route::get('/404', [HomeController::class, 'notFound']);


Route::dispatch();