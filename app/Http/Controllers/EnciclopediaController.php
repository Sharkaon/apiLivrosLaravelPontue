<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enciclopedia;

class EnciclopediaController extends Controller
{
    public function index(){
        $resposta = $this->mostrarTodos("App\Models\Enciclopedia");

        return $resposta;
    }

    public function show(int $id){
        $resposta = $this->mostrarUm("App\Models\Enciclopedia", $id);
        
        return $resposta;
    }

    public function store(Request $request){
        $enciclopedia = new enciclopedia;
        if($request->edicao){
            $enciclopedia->edicao = $request->edicao;
            $enciclopedia->editora = $request->editora;
            $enciclopedia->data_publi = $request->data_publi;
            $enciclopedia->save();
        }else{
            return response()->json([
                "mensagem" => "Título não pode ser nulo."
            ], 400);
        }

        return response()->json([
            "mensagem" => "Registro do enciclopedia criado"
        ], 201);
    }

    public function storeMany(Request $request){
        $enciclopediasRequests = $request->json()->all();

        foreach ($enciclopediasRequests as $enciclopediaRequest) {
            $enciclopedia = new enciclopedia;

            if(array_key_exists('edicao', $enciclopediaRequest)){
                $enciclopedia->edicao = $enciclopediaRequest['edicao'];

                if(array_key_exists('editora', $enciclopediaRequest))
                    $enciclopedia->editora = $enciclopediaRequest['editora'];

                if(array_key_exists('data_publi', $enciclopediaRequest))
                    $enciclopedia->data_publi = $enciclopediaRequest['data_publi'];

            }else{
                return response()->json([
                    "mensagem" => "Título não pode ser nulo."
                ], 400);
            }
        
        $enciclopedia->save();
        }

        return response()->json([
            "mensagem" => "Registros dos enciclopedias criados."
        ], 201);
    }

    public function update(int $id, Request $request){
        if(enciclopedia::where('id', $id)->exists()) {
            $enciclopedia = enciclopedia::where('id', $id)->firstOrFail();

            if($request->edicao)
                $enciclopedia->edicao = $request->edicao;

            if($request->editora)
                $enciclopedia->editora = $request->editora;

            if($request->data_publi)
                $enciclopedia->data_publi = $request->data_publi;

            $enciclopedia->save();

            return response()->json([
                "message" => "Registro atualizado com sucesso."
            ], 200);
        } else {
            return response()->json([
                "message" => "enciclopedia com esse id não existe."
            ], 400);
        }
    }

    public function destroy(int $id){
        $resposta = $this->deletar("App\Models\Enciclopedia", $id);
        
        return $resposta;
    }
}
