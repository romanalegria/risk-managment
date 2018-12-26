<?php

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

Route::get('/main', function () {
    return view('contenido/contenido');
})->name('main');
 
//Perfil
Route::get('/perfil', 'SAC000Controller@index');
Route::post('/perfil/registrar', 'SAC000Controller@store');
Route::put('/perfil/actualizar/{idPerfil}', 'SAC000Controller@update');
Route::put('/perfil/desactivar/{idPerfil}', 'SAC000Controller@desactivar');
Route::put('/perfil/activar/{idPerfil}', 'SAC000Controller@activar');

//Empresas Principales
Route::get('/empresa', 'SAC005Controller@index');
Route::post('/empresa/registrar', 'SAC005Controller@store');
Route::put('/empresa/actualizar/{idEmpresa}', 'SAC005Controller@update');
Route::put('/empresa/desactivar/{idEmpresa}', 'SAC005Controller@desactivar');
Route::put('/empresa/activar/{idEmpresa}', 'SAC005Controller@activar');

//Empresa Contratistas
Route::get('/contratista', 'SAC017Controller@index');
Route::post('/contratista/registrar', 'SAC017Controller@store');
Route::put('/contratista/actualizar/{idEmpresa}', 'SAC017Controller@update');
Route::put('/contratista/desactivar/{idEmpresa}', 'SAC017Controller@desactivar');
Route::put('/contratista/activar/{idEmpresa}', 'SAC017Controller@activar');

//Modulo
Route::get('/modulo', 'SAC002Controller@index');
Route::post('/modulo/registrar', 'SAC002Controller@store');
Route::put('/modulo/actualizar/{id}', 'SAC002Controller@update');
Route::put('/modulo/desactivar/{id}', 'SAC002Controller@desactivar');
Route::put('/modulo/activar/{id}', 'SAC002Controller@activar');
Route::get('/modulo/selectModulo', 'SAC002Controller@selectModulo');

//Funcionalidad Modulo
Route::get('/funcionalidad', 'SAC003Controller@index');
Route::post('/funcionalidad/registrar', 'SAC003Controller@store');
Route::put('/funcionalidad/actualizar/{id}', 'SAC003Controller@update');
Route::put('/funcionalidad/desactivar/{id}', 'SAC003Controller@desactivar');
Route::put('/funcionalidad/activar/{id}', 'SAC003Controller@activar');


Route::get('/','Auth\LoginController@showLoginForm');
Route::post('/login','Auth\LoginController@login')->name('login');

Route::get('/home', 'HomeController@index')->name('home');
