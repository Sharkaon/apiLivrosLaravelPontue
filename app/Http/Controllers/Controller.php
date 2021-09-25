<?php

namespace App\Http\Controllers;

use App\Models;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function mostrarTodos(string $model){
        $registros = $model::paginate(3)->toJson(JSON_PRETTY_PRINT);
        return response($registros, 200);
    }

    public function mostrarUm(string $model, int $id){
        if($model::where('id', $id)->exists()) {
            $registros = $model::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);

            return response($registros, 200);
        }else {
            return response()->json([
                "message" => "Registro com esse id não existe."
            ], 204);
        }
    }

    public function deletar(string $model, int $id){
        if($model::where('id', $id)->exists()) {
            $registro = $model::where('id', $id)->firstOrFail();
            $registro->delete();
 
            return response()->json([
                "message" => "Registro deletado com sucesso."
            ], 200);
         } else {
             return response()->json([
                 "message" => "Registro com esse id não existe."
             ], 400);
         }
    }
}
