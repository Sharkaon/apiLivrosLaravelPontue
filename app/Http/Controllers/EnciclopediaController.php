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
        $request->validate([
            'edicao' => 'required|string',
            'editora' => ['nullable', 'present'],
            'data_publi' => ['nullable', 'present']
        ]);

        return Enciclopedia::create($request->all());
    }

    public function update(int $id, Request $request){
        if(Enciclopedia::where('id', $id)->exists()) {
            $enciclopedia = Enciclopedia::where('id', $id)->firstOrFail();
            
            $enciclopedia->update($request->all());

            return $enciclopedia;
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
