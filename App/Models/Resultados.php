<?php

namespace App\Models;

class Resultados
{
    private static $table = 'resultados';

    public static function getClassificacaoProvasPorIdade()
    {
        $connectionPdo = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);

        $sql = 'SELECT
                    c.nome,
                    c.data_nascimento,
                    i.idade,
                    CASE WHEN i.idade BETWEEN 18 AND 25 THEN 1 
                            WHEN i.idade BETWEEN 26 AND 35 THEN 2 
                            WHEN i.idade BETWEEN 36 AND 45 THEN 3 
                            WHEN i.idade BETWEEN 46 AND 55 THEN 4 
                            WHEN i.idade > 55 THEN 5
                        END AS categoria_idade,
                    p.id AS id_prova,
                    p.tipo_prova,
                    p.data,
                    r.horario_inicio,
                    r.horario_fim,
                    TIMEDIFF(
                        r.horario_fim,
                        r.horario_inicio
                    ) AS tempo_prova
                FROM
                    resultados r
                JOIN provas p ON
                    r.id_prova = p.id
                JOIN corredores c ON
                    r.id_corredor = c.id_unico
                JOIN (SELECT
                        id_unico AS id_corredor,
                        DATE_FORMAT(
                            FROM_DAYS(
                                DATEDIFF(NOW(), data_nascimento)),
                                "%Y"
                            ) +0 AS idade
                        FROM
                            corredores
                        ) AS i ON
                        i.id_corredor = c.id_unico
                    ORDER BY
                        id_prova,
                        tempo_prova';

        $stmt = $connectionPdo->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("Nenhum resultado encontrado");
        }
    }

    public static function getClassificacaoProvasGerais()
    {
        $connectionPdo = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);

        $sql = 'SELECT
                    c.nome,
                    c.data_nascimento,
                    DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),c.data_nascimento)), "%Y")+0 AS idade,
                    p.id AS id_prova,
                    p.tipo_prova,
                    p.data,
                    r.horario_inicio,
                    r.horario_fim,
                    TIMEDIFF(
                        r.horario_fim,
                        r.horario_inicio
                    ) AS tempo_prova
                FROM
                    resultados r
                JOIN provas p ON
                    r.id_prova = p.id
                JOIN corredores c ON
                    r.id_corredor = c.id_unico  
                ORDER BY id_prova, tempo_prova';

        $stmt = $connectionPdo->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("Nenhum resultado encontrado");
        }
    }

    public static function insert($data)
    {
        $connectionPdo = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);

        $sql = 'INSERT INTO ' . self::$table . '(id_corredor, id_prova, horario_inicio, horario_fim) VALUES (:corredor, :prova, :hr_inicio, :hr_fim)';

        $stmt = $connectionPdo->prepare($sql);
        $stmt->bindValue(':corredor', $data['id_corredor']);
        $stmt->bindValue(':prova', $data['id_prova']);
        $stmt->bindValue(':hr_inicio', $data['horario_inicio']);
        $stmt->bindValue(':hr_fim', $data['horario_fim']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return 'Resultado inserido com sucesso!';
        } else {
            throw new \Exception("Não foi possível inserir Resultado.");
        }
    }
}
