<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;

class LivroController extends Controller
{
    public function index(){
        $resposta = $this->mostrarTodos("App\Models\Livro");

        return $resposta;
    }

    public function show(int $id){
        $resposta = $this->mostrarUm("App\Models\Livro", $id);
        
        return $resposta;
    }

    public function store(Request $request){
        $request->validate([
            'titulo' => 'required|string',
            'autor' => 'required|string',
            'editora' => 'nullable',
            'data_publi' => 'nullable'
        ]);

        return Livro::create($request->all());
    }

    public function update(int $id, Request $request){
        if(Livro::where('id', $id)->exists()) {
            $livro = Livro::where('id', $id)->firstOrFail();

            $livro->update($request->all());

            return $livro;
        } else {
            return response()->json([
                "message" => "Livro com esse id não existe."
            ], 400);
        }
    }

    public function destroy(int $id){
        $resposta = $this->deletar("App\Models\Livro", $id);
        
        return $resposta;
    }
}
