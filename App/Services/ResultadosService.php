<?php

namespace App\Services;

use App\Models\Resultados;

class ResultadosService
{
    public function get($idade = null)
    {
        if ($idade === 'idade') {
            return $this->prepareClassificacaoPorGrupo(Resultados::getClassificacaoProvasPorIdade());
        } else {
            return $this->prepareClassificacaoPorTipoProva(Resultados::getClassificacaoProvasGerais());
        }
    }

    public function post()
    {
        $this->validaPost($_POST);
        return Resultados::insert($_POST);
    }

    private function validaPost(array $post)
    {
        if (!$post['id_corredor'] || !$post['id_prova'] || !$post['horario_inicio'] || !$post['horario_fim']) {
            throw new \Exception("Todos os campos devem ser preenchidos.");
        }
    }

    private function prepareClassificacaoPorTipoProva(array $dados_classificacao_geral)
    {
        if (!$dados_classificacao_geral) {
            throw new \Exception('Nenhum registro encontrado.');
        }

        $classificacao_por_tipo_prova = [];

        foreach ($dados_classificacao_geral as $dados) {
            $classificacao_por_tipo_prova['tipo_prova_' . $dados['tipo_prova']][] = $dados;
            $index = array_key_last($classificacao_por_tipo_prova['tipo_prova_' . $dados['tipo_prova']]);
            $classificacao_por_tipo_prova['tipo_prova_' . $dados['tipo_prova']][$index]['posicao'] = $index + 1;
        }

        return $classificacao_por_tipo_prova;
    }

    private function prepareClassificacaoPorGrupo(array $dados_classificacao_por_idade)
    {
        if (!$dados_classificacao_por_idade) {
            throw new \Exception('Nenhum registro encontrado.');
        }

        $classificacao_por_grupo = [];

        foreach ($dados_classificacao_por_idade as $dados) {
            switch ($dados['categoria_idade']) {
                case 1:
                    $classificacao_por_grupo['tipo_prova_' . $dados['tipo_prova']]['18-25 anos'][] = $dados;
                    $index = array_key_last($classificacao_por_grupo['tipo_prova_' . $dados['tipo_prova']]['18-25 anos']);
                    $classificacao_por_grupo['tipo_prova_' . $dados['tipo_prova']]['18-25 anos'][$index]['posicao'] = $index + 1;
                    break;
                case 2:
                    $classificacao_por_grupo['tipo_prova_' . $dados['tipo_prova']]['26-35 anos'][] = $dados;
                    $index = array_key_last($classificacao_por_grupo['tipo_prova_' . $dados['tipo_prova']]['26-35 anos']);
                    $classificacao_por_grupo['tipo_prova_' . $dados['tipo_prova']]['26-35 anos'][$index]['posicao'] = $index + 1;
                    break;
                case 3:
                    $classificacao_por_grupo['tipo_prova_' . $dados['tipo_prova']]['36-45 anos'][] = $dados;
                    $index = array_key_last($classificacao_por_grupo['tipo_prova_' . $dados['tipo_prova']]['36-45 anos']);
                    $classificacao_por_grupo['tipo_prova_' . $dados['tipo_prova']]['36-45 anos'][$index]['posicao'] = $index + 1;
                    break;
                case 4:
                    $classificacao_por_grupo['tipo_prova_' . $dados['tipo_prova']]['46-55 anos'][] = $dados;
                    $index = array_key_last($classificacao_por_grupo['tipo_prova_' . $dados['tipo_prova']]['46-55 anos']);
                    $classificacao_por_grupo['tipo_prova_' . $dados['tipo_prova']]['46-55 anos'][$index]['posicao'] = $index + 1;
                    break;
                case 5:
                    $classificacao_por_grupo['tipo_prova_' . $dados['tipo_prova']]['55+ anos'][] = $dados;
                    $index = array_key_last($classificacao_por_grupo['tipo_prova_' . $dados['tipo_prova']]['55+ anos']);
                    $classificacao_por_grupo['tipo_prova_' . $dados['tipo_prova']]['55+ anos'][$index]['posicao'] = $index + 1;
                    break;
            }
        }

        return $classificacao_por_grupo;
    }
}
