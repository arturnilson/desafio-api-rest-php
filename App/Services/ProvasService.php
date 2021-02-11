<?php

namespace App\Services;

use App\Models\Provas;
use App\Helpers\Helper;

class ProvasService
{
    private static $tipos_prova_permitidos = [3, 5, 10, 21, 42];


    public function get($id = null)
    {
        if ($id) {
            return Provas::select($id);
        } else {
            return Provas::selectAll();
        }
    }

    public function post()
    {
        $_POST['data'] = Helper::dateToBD($_POST['data']);
        $this->checkTipoProva($_POST['tipo_prova']);

        return Provas::insert($_POST);
    }

    private function checkTipoProva($tipo_prova)
    {
        if (!in_array($tipo_prova, self::$tipos_prova_permitidos)) {
            throw new \Exception("Tipo de prova inválido. Tipos de provas permitidos: 3, 5, 10, 21, 42");
        }
    }
}
