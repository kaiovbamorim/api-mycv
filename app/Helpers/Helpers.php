<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Helpers
{
    public function Requisicao()
    {
        $Repostas = ['resposta' => [
            'data' => [
                'ok' => false,
            ],
            'toast' => [
                'icon' => '',
                'position' => 'top',
                'mensagem' => '',
                'color' => '',
            ]
        ]];

        return $Repostas;
    }

    public function PegaDadosUsuario($Email)
    {
        $DadosUsuario = DB::table('SIS_USUARIOS')
        ->select('ID','NOME', 'EMAIL', 'SENHA')
        ->where('EMAIL', $Email)
        ->first();

        return $DadosUsuario;
    }
}
