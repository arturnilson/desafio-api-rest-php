<?php

namespace App\Models;

class Resultados
{
    private static $table = 'resultados';

    public static function select(int $id)
    {
        $connectionPdo = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);

        $sql = 'SELECT * FROM ' . self::$table . ' WHERE id_corredor = ' . $id;

        $stmt = $connectionPdo->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("Nenhum resultado encontrado");
        }
    }

    public static function selectAll()
    {
        $connectionPdo = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);

        $sql = 'SELECT * FROM ' . self::$table;

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
