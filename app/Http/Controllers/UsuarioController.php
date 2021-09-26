<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Reponse;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsuarioController extends Controller
{
    public function cadastrar(Request $request){
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

    public function sair(Request $request){
        auth()->user()->tokens()->delete();

        return response()->json([
            'mensagem' => 'Usuario deslogado'
        ], 200);
    }
}
