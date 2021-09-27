<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enciclopedia;

class EnciclopediaController extends Controller
{
    /**
     * Mostra todas as enciclopedias cadastrados.
     * 
     * Chama o método mostrarTodos da sua classe pai e retorna o retorno de tal método.
     * 
     * @return Response A resposta enviada pelo método da classe pai.
     */
    public function index(){
        $resposta = $this->mostrarTodos("App\Models\Enciclopedia");

        return $resposta;
    }

    /**
     * Mostra uma enciclopedia cadastrada.
     * 
     * Chama o método mostrarUm da sua classe pai e retorna o retorno de tal método.
     * 
     * @param int $id O Id da enciclopedia que deseja mostrar.
     * @return Response A resposta enviada pelo método da classe pai.
     */
    public function show(int $id){
        $resposta = $this->mostrarUm("App\Models\Enciclopedia", $id);
        
        return $resposta;
    }

    /**
     * Cadastra um enciclopedia
     * 
     * Recebe uma request com um campo obrigatórios, edição, e dois opcionais,
     * editora e data de publicação e salva esses dados, retornando as informações da enciclopedia
     * criado no banco. Não é abstraído pois usa campos únicos.
     * 
     * @param Request $request A requisição feita pelo usuário.
     * @return Response O registro criado pelo método create
     */
    public function store(Request $request){
        $request->validate([
            'edicao' => 'required|string',
            'editora' => ['nullable', 'present'],
            'data_publi' => ['nullable', 'present']
        ]);

        return Enciclopedia::create($request->all());
    }
    
    /**
     * Atualiza um enciclopedia cadastrado
     * 
     * Recebe uma request e um id, procura uma enciclopédia que tenha o mesmo Id, se não houver,
     * envia uma resposta informando o usuário, se houver, verifica quais campos existem na
     * requisição e atualiza o registro de acordo. Não é abstraído por ter campos únicos
     * 
     * @param Request $request A requisição feita pelo usuário.
     * @param int $id O id do registro que o usuário deseja atualizar.
     * @return Response|Response Uma mensagem json com a enciclopedia atualizado ou uma mensagem
     * JSON com status 400 informando que a enciclopedia não foi encontrado.
     */
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

    /**
     * Apaga o registro de uma enciclopedia cadastrada.
     * 
     * Recebe um id e chama o método na classe pai responsável por deletar registros, após isso,
     * retorna o que recebeu do método da classe pai.
     * 
     * @param int $id O id do registro que deseja apagar.
     * @return Response A resposta enviada pelo método da classe pai.
     */
    public function destroy(int $id){
        $resposta = $this->deletar("App\Models\Enciclopedia", $id);
        
        return $resposta;
    }
}
