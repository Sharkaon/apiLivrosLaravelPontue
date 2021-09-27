<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;

/**
 * Classe responsável pelo gerenciamente de livros.
 * 
 * @author Artur Monteiro
 */
class LivroController extends Controller
{
    /**
     * Mostra todos os livros cadastrados.
     * 
     * Chama o método mostrarTodos da sua classe pai e retorna o retorno de tal método.
     * 
     * @return Response A resposta enviada pelo método da classe pai.
     */
    public function index(){
        $resposta = $this->mostrarTodos("App\Models\Livro");

        return $resposta;
    }

    /**
     * Mostra um livro cadastrado.
     * 
     * Chama o método mostrarUm da sua classe pai e retorna o retorno de tal método.
     * 
     * @param int $id O Id do livro que deseja mostrar.
     * @return Response A resposta enviada pelo método da classe pai.
     */
    public function show(int $id){
        $resposta = $this->mostrarUm("App\Models\Livro", $id);
        
        return $resposta;
    }

    /**
     * Cadastra um livro
     * 
     * Recebe uma request com dois campos obrigatórios, título e autor, e dois opcionais,
     * editora e data de publicação e salva esses dados, retornando as informações do livro
     * criado no banco. Não é abstraído pois usa campos únicos.
     * 
     * @param Request $request A requisição feita pelo usuário.
     * @return Response O registro criado pelo método create
     */
    public function store(Request $request){
        $request->validate([
            'titulo' => 'required|string',
            'autor' => 'required|string',
            'editora' => 'nullable',
            'data_publi' => 'nullable'
        ]);

        return Livro::create($request->all());
    }
    
    /**
     * Atualiza um livro cadastrado
     * 
     * Recebe uma request e um id, procura um Livro que tenha o mesmo Id, se não houver, envia
     * uma resposta informando o usuário, se houver, verifica quais campos existem na requisição
     * e atualiza o registro de acordo. Não é abstraído por ter campos únicos
     * 
     * @param Request $request A requisição feita pelo usuário.
     * @param int $id O id do registro que o usuário deseja atualizar.
     * @return Response|Response Uma mensagem json com o livro atualizado ou uma mensagem JSON com status
     * 400 informando que o livro não foi encontrado.
     */
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

    /**
     * Apaga o registro de um livro cadastrado.
     * 
     * Recebe um id e chama o método na classe pai responsável por deletar registros, após isso,
     * retorna o que recebeu do método da classe pai.
     * 
     * @param int $id O id do registro que deseja apagar.
     * @return Response A resposta enviada pelo método da classe pai.
     */
    public function destroy(int $id){
        $resposta = $this->deletar("App\Models\Livro", $id);
        
        return $resposta;
    }
}
