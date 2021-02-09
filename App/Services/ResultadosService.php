<?php

namespace App\Services;

use App\Models\Resultados;

class ResultadosService
{
    public function get($id = null)
    {
        if ($id) {
            return Resultados::select($id);
        } else {
            return Resultados::selectAll();
        }
    }

    public function post()
    {
        return Resultados::insert($_POST);
    }
}
