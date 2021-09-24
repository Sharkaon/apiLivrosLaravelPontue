<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\EnciclopediaController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('livros', [LivroController::class, 'index']);
Route::get('livros/{id}', [LivroController::class, 'show']);
Route::post('livros', [LivroController::class, 'store']);
Route::post('livros/many', [LivroController::class, 'storeMany']);
Route::put('livros/{id}', [LivroController::class, 'update']);
Route::patch('livros/{id}', [LivroController::class, 'update']);
Route::delete('livros/{id}', [LivroController::class, 'destroy']);
Route::delete('livros/{id1}/{id2}', [LivroController::class, 'destroyMany']);

Route::get('enciclopedias', [EnciclopediaController::class, 'index']);
Route::get('enciclopedias/{id}', [EnciclopediaController::class, 'show']);
Route::post('enciclopedias', [EnciclopediaController::class, 'store']);
Route::post('enciclopedias/many', [EnciclopediaController::class, 'storeMany']);
Route::put('enciclopedias/{id}', [EnciclopediaController::class, 'update']);
Route::patch('enciclopedias/{id}', [EnciclopediaController::class, 'update']);
Route::delete('enciclopedias/{id}', [EnciclopediaController::class, 'destroy']);
Route::delete('enciclopedias/{id1}/{id2}', [EnciclopediaController::class, 'destroyMany']);