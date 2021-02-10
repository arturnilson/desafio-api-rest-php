<?php

namespace App\Services;

use App\Models\Provas;
use App\Helpers\Helper;

class ProvasService
{
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
        $_POST['data'] = Helper::date_to_bd($_POST['data']);

        return Provas::insert($_POST);
    }
}
