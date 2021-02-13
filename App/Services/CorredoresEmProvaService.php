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
        if ($_POST['id_corredor'] && $_POST['id_prova']) {
            $this->hasCompeticaoMesmaData($_POST);
            return CorredoresEmProva::insert($_POST);
        } else {
            throw new \Exception("Informe o id_corredor e o id_prova.");
        }
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
