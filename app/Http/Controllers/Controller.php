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

    /**
     * Mostra todos os registros de uma entidade.
     * 
     * Recebe o nome de um modelo e devolve todos os registros de tal entidade, paginando-os com
     * 5 em cada página.
     * 
     * @param string $model O nome do modelo que deseja ver os registros.
     * @return Response Uma resposta em JSON com todos os dados encontrados no banco de dados e
     * status 200.
     */
    public function mostrarTodos(string $model){
        $registros = $model::paginate(5)->toJson(JSON_PRETTY_PRINT);
        return response($registros, 200);
    }

    /**
     * Mostra um registro de uma entidade.
     * 
     * Recebe o nome de um modelo e um id e devolve o registro daquele modelo com o Id informado.
     * 
     * @param string $model O nome do modelo que deseja ver o registro.
     * @return Response|Response Uma resposta em JSON com o registro correspondente e status 200
     * ou uma mensagem com status 204 avisando que não há registros.
     */
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

    /**
     * Deleta um registro de uma entidade.
     * 
     * Recebe o nome de um modelo e um id, procura um registro com aquele Id no modelo informado,
     * se houver, deleta ele e retorna uma mensagem JSON informando, se não houver, retorna outra
     * mensagem avisando que não foram encontrados registros.
     * 
     * @param string $model O nome do modelo da onde se deseja deleter o registro.
     * @return Response|Response Uma resposta em JSON de status 200 avisando que o registro foi
     * deletado ou uma resposta em JSON de status 400 avisando que não foi encontrado o
     * registro solicitado.
     */
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
