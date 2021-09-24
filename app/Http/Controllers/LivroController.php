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
                $livro->editor = $request->editor;
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

    public function update(int $id, Request $request){
        if(Livro::where('id', $id)->exists()) {
            $livro = Livro::where('id', $id)->firstOrFail();

            if($request->titulo)
                $livro->titulo = $request->titulo;

            if($request->autor)
                $livro->autor = $request->autor;

            if($request->editor)
                $livro->editor = $request->editor;

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
               "message" => "Registro do livro deletado."
           ], 200);
        } else {
            return response()->json([
                "message" => "Livro com esse id não existe."
            ], 400);
        }
    }
}
