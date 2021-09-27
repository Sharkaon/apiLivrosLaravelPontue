<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Reponse;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * Classe responsável pelo gerenciamento de usuários e tokens de acesso a API
 * 
 * @author Artur Monteiro
 */
class UsuarioController extends Controller
{
    /**
     * Cadastro de usuários que cria e retorna um token de acesso a API
     * 
     * Recebe uma request com três campos obrigatórios, nome, email e senha, cria um usuário
     * com os campos checados e cria um Token com base no emai desse usuário, por fim
     * retorna uma mensagem JSON incluindo o token.
     * 
     * @param Request $request  A request mandada pelo usuário para a API.
     * @return Response retorna uma resposta JSON com status de 201, o nome do usuário e o token. 
     */
    public function cadastrar(Request $request){
        // Checagem de dados
        $campos = $request->validate([
            'nome' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'senha' => 'required|string'
        ]);

        $usuario = User::create([
            'name' => $campos['nome'],
            'email' => $campos['email'],
            'password' => bcrypt($campos['senha'])
        ]);

        $token = $usuario->createToken($usuario->email)->plainTextToken;

        return response()->json([
            'user' => $usuario,
            'token' => $token
        ], 201);
    }

    /**
     * Login de usuários que rria e retorna um token de acesso
     * 
     * Recebe uma request com dois valores obrigatórios, email e senha, que usa então para
     * comparar com emails e senhas no banco de dados e, se houver algum resultado positivo,
     * cria um novo token para esse usuário e retorna uma mensagem JSON com ele.
     * 
     * @param Request $request  A request mandada pelo usuário para a API.
     * @return Response|Response|Response retorna uma resposta JSON com status de 201, o nome do
     * usuário e o token, ou com status de 401 explicando o erro. 
     */
    public function entrar(Request $request){
        $campos = $request->validate([
            'email' => 'required|string',
            'senha' => 'required|string'
        ]);

        $usuario = User::where('email', $campos['email'])->first();

        if($usuario){
            if(!Hash::check($campos['senha'], $usuario->password)){
                return response()->json([
                    'mensagem' => 'Senha incorreta.'
                ], 401);
            }
        }else{
            return response()->json([
                'mensagem' => 'Usuario com esse email nao encontrado'
            ], 401);
        }

        $token = $usuario->createToken($usuario->email)->plainTextToken;

        return response()->json([
            'user' => $usuario,
            'token' => $token
        ], 201);
    }

    /**
     * Método para deslogar usuários
     * 
     * Apaga todos os tokens atualmente criados relacionados ao usuário, tirando seu acesso.
     * 
     * @param Request $request  A request mandada pelo usuário para a API.
     * @return Response retorna uma resposta JSON com status de 200, e uma mensagem. 
     */
    public function sair(){
        auth()->user()->tokens()->delete();

        return response()->json([
            'mensagem' => 'Usuario deslogado'
        ], 200);
    }
}
