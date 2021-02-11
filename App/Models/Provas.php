<?php

namespace App\Models;

class Provas
{
    private static $table = 'provas';

    public static function select(int $id)
    {
        $connectionPdo = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);

        $sql = 'SELECT * FROM ' . self::$table . ' WHERE id = ' . $id;

        $stmt = $connectionPdo->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } else {
            return null;
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
            throw new \Exception("Nenhuma prova encontrada");
        }
    }

    public static function insert($data)
    {
        $connectionPdo = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);

        $sql = 'INSERT INTO ' . self::$table . '(tipo_prova, data) VALUES (:tipo_prova, :data)';

        $stmt = $connectionPdo->prepare($sql);
        $stmt->bindValue(':tipo_prova', $data['tipo_prova']);
        $stmt->bindValue(':data', $data['data']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return 'Prova inserida com sucesso!';
        } else {
            throw new \Exception("Não foi possível inserir Prova.");
        }
    }
}
