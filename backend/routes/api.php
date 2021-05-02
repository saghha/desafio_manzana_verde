<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'RegisterController@register');
});
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('pedido/cliente', 'PedidoController@pedidos');
    Route::apiResource('comida', 'ComidaController');
    Route::apiResource('pedido', 'PedidoController');
    Route::apiResource('pedido-comida', 'PedidoComidaController');
});