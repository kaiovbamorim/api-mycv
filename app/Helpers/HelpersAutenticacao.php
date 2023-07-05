<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class HelpersAutenticacao
{
    public function VerificaEmailExistente(string $Email, string $NomeTabela)
    {
        $QrEmail = DB::table($NomeTabela)
            ->where('email', $Email)
            ->exists();

        return $QrEmail;
    }


    public function Login(string $Email, string $Senha)
    {

        $resultado = DB::table('sis_usuarios')
            ->where('email', $Email)
            ->where('senha', $Senha)
            ->first();

        return $resultado;
    }
}
