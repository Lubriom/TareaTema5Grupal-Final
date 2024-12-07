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
Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);
Route::get('/crearBD', [UsuarioController::class, 'create']);
Route::get('/login', [LoginController::class, 'index']);
Route::get('/logout', [LoginController::class, 'logout']);
Route::get('/usuario/nuevo', [UsuarioController::class, 'create']);
Route::get('/usuario/pruebas', [UsuarioController::class, 'pruebasSQLQueryBuilder']);
Route::get('/usuario/:id', [UsuarioController::class, 'show']);
Route::post('/usuario', [UsuarioController::class, 'store']);
Route::post('/login/check', [LoginController::class, 'check']);
Route::post('/registro', [RegisterController::class, 'index']);

 
Route::dispatch();