<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::post('/api/register','App\Http\Controllers\UserController@register');
Route::post('/api/login','App\Http\Controllers\UserController@login');

//Route::resource('/api/incidencia', 'App\Http\Controllers\IncidenciaController');
Route::get('/api/incidencia', 'App\Http\Controllers\IncidenciaController@index');
Route::post('/api/incidenciaUsuario', 'App\Http\Controllers\IncidenciaController@show');
Route::post('/api/incidenciaFecha', 'App\Http\Controllers\IncidenciaController@showDates');
    
