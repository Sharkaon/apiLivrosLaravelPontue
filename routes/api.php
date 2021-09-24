<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivroController;

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
Route::post('livros', [LivroController::class, 'create']);
Route::put('livros/{id}', [LivroController::class, 'update']);
Route::delete('livros/{id}', [LivroController::class, 'destroy']);