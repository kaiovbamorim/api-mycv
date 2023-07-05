<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// IMPORTS HELPERS
use App\Helpers\Helpers;
use App\Helpers\HelpersAutenticacao;
use App\Helpers\HelpersCurriculo;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $Helpers;
    protected $HelpersAutenticacao;
    protected $HelpersCurriculo;

    public function __construct(){

        // HELPERS

        $this->Helpers = new Helpers();
        $this->HelpersAutenticacao = new HelpersAutenticacao();
        $this->HelpersCurriculo = new HelpersCurriculo();

    }
}
