<?php

namespace App\Services;

use App\Models\Corredores;
use App\Helpers\Helper;

class CorredoresService
{
    public function get($id = null)
    {
        if ($id) {
            return Corredores::select($id);
        } else {
            return Corredores::selectAll();
        }
    }

    public function post()
    {
        $_POST['data_nascimento'] = Helper::date_to_bd($_POST['data_nascimento']);
        $this->validaIdade($_POST['data_nascimento']);

        return Corredores::insert($_POST);
    }

    private function validaIdade($data_nascimento)
    {
        $date = new \DateTime($data_nascimento);
        $interval = $date->diff(new \DateTime(date('Y-m-d')));

        if ($interval->format('%Y') < 18) {
            throw new \Exception("Não é permitido inserir corredores menores de 18 anos.");
        }
    }
}
