<?php

namespace App\Services;

use App\Models\CorredoresEmProva;
use App\Models\Provas;

class CorredoresEmProvaService
{
    public function get()
    {
        return CorredoresEmProva::selectAll();
    }

    public function post()
    {
        $this->hasCompeticaoMesmaData($_POST);

        return CorredoresEmProva::insert($_POST);
    }

    private function hasCompeticaoMesmaData($post)
    {
        $competicoes = CorredoresEmProva::getCorredoresEmProvasByUnico($post['id_corredor']);
        $prova = Provas::select($post['id_prova']);

        if ($competicoes && $prova) {
            foreach ($competicoes as $competicao) {
                if (in_array($prova['data'], $competicao)) {
                    throw new \Exception("Competidor(a) já possui prova marcada nesta data.");
                }
            }
        }
    }
}
