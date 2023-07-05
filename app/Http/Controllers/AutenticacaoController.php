<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AutenticacaoController extends Controller
{

    public function Login(Request $Request)
    {

        // Inserir os dados do usuário no banco de dados

        $Resposta = $this->Helpers->Requisicao();

        $Validacao = Validator::make(
            $Request->all(),
            [
                'EMAIL' => 'required|email',
                'SENHA' => 'required|min:6'
            ],
            [
                'EMAIL.required' => "Por favor informe seu EMAIL para efetuar login!",
                'EMAIL.email' => "Por favor informe um EMAIL válido!",
                'SENHA.required' => "Por favor informe a sua senha!",
                'SENHA.min' => "Por favor informe uma senha válida!"
            ]
        );
        if ($Validacao->errors()->first()) {
            $Resposta['resposta']['toast']['mensagem'] = strval($Validacao->errors()->first());
            $Resposta['resposta']['toast']['icon'] = 'close-circle-outline';
            $Resposta['resposta']['toast']['color'] = 'danger';
            return response()->json($Resposta);
        }

        $DadosUsuario = $this->Helpers->PegaDadosUsuario($Request->EMAIL);
        if ($DadosUsuario) {
            $Login = $this->HelpersAutenticacao->Login($Request->EMAIL, $Request->SENHA);
            if (!empty($Login)) {
                $Resposta['resposta']['toast']['mensagem'] = "Olá, $Login->NOME seja bem-vindo!";
                $Resposta['resposta']['toast']['icon'] = 'checkmark-circle-outline';
                $Resposta['resposta']['toast']['color'] = 'success';
                $Resposta['resposta']['data']['ok'] = true;
                return response()->json($Resposta);
            }
            if (empty($Login)) {
                $Resposta['resposta']['toast']['mensagem'] = 'Email ou senha incorretos!';
                $Resposta['resposta']['toast']['icon'] = 'close-circle-outline';
                $Resposta['resposta']['toast']['color'] = 'danger';
                return response()->json($Resposta);
            }
        }
        if (!$DadosUsuario) {
            $Resposta['resposta']['toast']['mensagem'] = "Não existe uma conta com esse Email, clique em registre-se, e crie sua conta!";
            $Resposta['resposta']['toast']['icon'] = 'close-circle-outline';
            $Resposta['resposta']['toast']['color'] = 'danger';
            return response()->json($Resposta);
        }


        return response()->json($Resposta);
    }

    public function RegistrarUsuario(Request $Request)
    {
        $Validacao = Validator::make(
            $Request->all(),
            [
                'EMAIL' => 'required|email',
                'NOME' => 'required|min:3',
                'SENHA' => 'required|min:6',
            ],
            [   
                
                'EMAIL.required' => "Por favor informe seu email para efetuar login!",
                'EMAIL.email' => "Por favor informe um email válido!",
                'NOME.required' => "Por favor insira seu nome!",
                'NOME.min' => "Por favor insira seu nome completo",
                'SENHA.required' => "Por favor informe a sua senha!",
                'SENHA.min' => "Por favor informe uma senha válida!"
            ]
        );
        if ($Validacao->errors()->first()) {
            $Resposta['resposta']['toast']['mensagem'] = strval($Validacao->errors()->first());
            $Resposta['resposta']['toast']['icon'] = 'close-circle-outline';
            $Resposta['resposta']['toast']['color'] = 'danger';
            return response()->json($Resposta);
        }
        // Inserir os dados do usuário no banco de dados
        $Resposta = $this->Helpers->Requisicao();

        $EmailExistente = $this->HelpersAutenticacao->VerificaEmailExistente($Request->EMAIL, 'sis_usuarios');
        if (!$EmailExistente) {
            DB::table('sis_usuarios')->insert([
                'NOME' => $Request->NOME,
                'EMAIL' => $Request->EMAIL,
                'SENHA' => $Request->SENHA,
            ]);
            $Resposta['resposta']['toast']['mensagem'] = 'Usuário cadastrado com sucesso!';
            $Resposta['resposta']['toast']['icon'] = 'checkmark-circle-outline';
            $Resposta['resposta']['toast']['color'] = 'success';
            $Resposta['resposta']['data']['ok'] = true;
            return response()->json($Resposta);
        }
        if ($EmailExistente) {
            $Resposta['resposta']['toast']['mensagem'] = 'Email já existente, por favor tente outro!';
            $Resposta['resposta']['toast']['icon'] = 'close-circle-outline';
            $Resposta['resposta']['toast']['color'] = 'danger';
            return response()->json($Resposta);
        }
    }
}
