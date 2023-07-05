<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class CurriculoController extends Controller
{

    // INSERE NO BANCO AS INFORMAÇÕES PESSOAIS DO CURRICULO
    public function CadastraInfoPessoais(Request $Request)
    {

        $Validacao = Validator::make(
            $Request->all(),
            [
                'NOME' => 'required|min:6',
                'EMAIL' => 'required|email',
                'TELEFONE' => 'min:11|max:11',
                'ESTADO' => 'required',
                'LINK' => 'required',
                'CARGODESEJADO' => 'required',
            ],
            [
                'NOME.required' => "Por favor insira seu nome!",
                'NOME.min' => "Por favor insira seu nome completo",
                'EMAIL.required' => "Por favor informe seu EMAIL para efetuar login!",
                'EMAIL.email' => "Por favor informe um EMAIL válido!",
                'TELEFONE.min' => "Por favor insira um telefone válido!",
                'TELEFONE.min' => "Por favor insira um telefone válido!",
                'ESTADO.required' => "Por favor selecione um Estado!",
                'LINK.required' => "Por favor insira um link!",
                'CARGODESEJADO.required' => "Por favor insira um cargo que deseje!"
            ]
        );
        if ($Validacao->errors()->first()) {
            $Resposta['resposta']['toast']['mensagem'] = strval($Validacao->errors()->first());
            $Resposta['resposta']['toast']['icon'] = 'close-circle-outline';
            $Resposta['resposta']['toast']['color'] = 'danger';
            return response()->json($Resposta);
        }

        // VERIFICA SE JÁ EXISTE O EMAIL
        $EmailExistente = $this->HelpersAutenticacao->VerificaEmailExistente($Request->EMAIL, 'sis_curriculo');


        if ($EmailExistente) {
            DB::table('sis_curriculo')
                ->where('EMAIL', $Request->EMAIL)
                ->update([
                    'NOME' => $Request->NOME,
                    'TELEFONE' => $Request->TELEFONE,
                    'CARGODESEJADO' => $Request->CARGODESEJADO,
                    'LINK' => $Request->LINK,
                    'ESTADO' => $Request->ESTADO,
                ]);

            $Resposta['resposta']['data']['ok'] = true;
        }

        if (!$EmailExistente) {
            DB::table('sis_curriculo')->insert([
                'NOME' => $Request->NOME,
                'EMAIL' => $Request->EMAIL,
                'TELEFONE' => $Request->TELEFONE,
                'CARGODESEJADO' => $Request->CARGODESEJADO,
                'LINK' => $Request->LINK,
                'ESTADO' => $Request->ESTADO,
            ]);

            $Resposta['resposta']['data']['ok'] = true;
        }

        return response()->json($Resposta);
    }

    // INSERE NO BANCO OS OBJETIVO E RESUMOS PROFISSIONAIS
    public function CadastraObjetivoResumo(Request $Request)
    {

        $Resposta = $this->Helpers->Requisicao();

        $Validacao = Validator::make(
            $Request->all(),
            [
                'RESUMO' => 'required',
                'OBJETIVO' => 'required'
            ],
            [
                'NOME.required' => "Por favor insira seu resumo profissional!",
                'OBJETIVO.required' => "Por favor insira seu objetivo profissional!",
            ]
        );
        if ($Validacao->errors()->first()) {
            $Resposta['resposta']['toast']['mensagem'] = strval($Validacao->errors()->first());
            $Resposta['resposta']['toast']['icon'] = 'close-circle-outline';
            $Resposta['resposta']['toast']['color'] = 'danger';
            return response()->json($Resposta);
        }


        DB::table('sis_resumo_objetivo')->insert([
            'OBJETIVO' => $Request->OBJETIVO,
            'RESUMO' => $Request->RESUMO,
        ]);

        $Resposta['resposta']['data']['ok'] = true;
        return response()->json($Resposta);
    }

    // INSERE NO BANCO AS HABILIDADES DO CURRÍCULO
    public function CadastraHabilidades(Request $Request)
    {

        $Resposta = $this->Helpers->Requisicao();
        $Habilidades = $Request;

        if (!empty($Habilidades)) {
            DB::table('sis_habilidades')->insert([
                'HABILIDADES' => $Habilidades
            ]);

            $Resposta['resposta']['toast']['mensagem'] = 'Pronto, agora você pode aproveitar dos nossos currículos, e já aplicar para vagas. Boa sorte!';
            $Resposta['resposta']['toast']['icon'] = 'checkmark-circle-outline';
            $Resposta['resposta']['toast']['color'] = 'primary';
            $Resposta['resposta']['data']['ok'] = true;

            return response()->json($Resposta);
        }


        return response()->json($Resposta);
    }
}
