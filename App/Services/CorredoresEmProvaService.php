<?php

namespace App\Services;

use App\Models\CorredoresEmProva;

class CorredoresEmProvaService
{
    public function get()
    {
        return CorredoresEmProva::selectAll();
    }

    public function post()
    {
        return CorredoresEmProva::insert($_POST);
    }
}
