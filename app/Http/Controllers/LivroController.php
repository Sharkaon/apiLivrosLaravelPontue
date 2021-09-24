<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;

class LivroController extends Controller
{
    public function index(){
        $livros = Livro::get()->toJson(JSON_PRETTY_PRINT);
        return response($livros, 200);
    }

    public function show(int $id){
        if(Livro::where('id', $id)->exists()) {
            $livro = Livro::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($livro, 200);
        } else {
            return response()->json([
                "message" => "Livro com esse id não existe."
            ], 204);
        }
    }

    public function store(Request $request){
        $livro = new Livro;
        if($request->titulo){
            $livro->titulo = $request->titulo;
            if($request->autor){
                $livro->autor = $request->autor;
                $livro->editora = $request->editora;
                $livro->data_publi = $request->data_publi;
                $livro->save();
            }else{
                return response()->json([
                    "mensagem" => "Autor não pode ser nulo."
                ], 400);
            }
        }else{
            return response()->json([
                "mensagem" => "Título não pode ser nulo."
            ], 400);
        }

        return response()->json([
            "mensagem" => "Registro do livro criado"
        ], 201);
    }

    public function storeMany(Request $request){
        $livrosRequests = $request->json()->all();

        foreach ($livrosRequests as $livroRequest) {
            $livro = new Livro;

            if(array_key_exists('titulo', $livroRequest)){
                $livro->titulo = $livroRequest['titulo'];

                if(array_key_exists('autor', $livroRequest)){
                    $livro->autor = $livroRequest['autor'];

                    if(array_key_exists('editora', $livroRequest))
                        $livro->editora = $livroRequest['editora'];

                    if(array_key_exists('data_publi', $livroRequest))
                        $livro->data_publi = $livroRequest['data_publi'];
                }else{
                    return response()->json([
                        "mensagem" => "Autor não pode ser nulo."
                    ], 400);
                }

            }else{
                return response()->json([
                    "mensagem" => "Título não pode ser nulo."
                ], 400);
            }
        
        $livro->save();
        }

        return response()->json([
            "mensagem" => "Registros dos livros criados."
        ], 201);
    }

    public function update(int $id, Request $request){
        if(Livro::where('id', $id)->exists()) {
            $livro = Livro::where('id', $id)->firstOrFail();

            if($request->titulo)
                $livro->titulo = $request->titulo;

            if($request->autor)
                $livro->autor = $request->autor;

            if($request->editora)
                $livro->editora = $request->editora;

            if($request->data_publi)
                $livro->data_publi = $request->data_publi;

            $livro->save();

            return response()->json([
                "message" => "Registro atualizado com sucesso."
            ], 200);
        } else {
            return response()->json([
                "message" => "Livro com esse id não existe."
            ], 400);
        }
    }

    public function destroy(int $id){
        if(Livro::where('id', $id)->exists()) {
           $livro = Livro::where('id', $id)->firstOrFail();
           $livro->delete();

           return response()->json([
               "message" => "Registro do livro deletado com sucesso."
           ], 200);
        } else {
            return response()->json([
                "message" => "Livro com esse id não existe."
            ], 400);
        }
    }
}
