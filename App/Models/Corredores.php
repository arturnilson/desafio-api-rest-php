<?php

namespace App\Models;

class Corredores
{
    private static $table = 'corredores';

    public static function select(int $id)
    {
        $connectionPdo = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);

        $sql = 'SELECT * FROM ' . self::$table . ' WHERE id_unico = ' . $id;

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

        $sql = 'INSERT INTO ' . self::$table . '(nome, cpf, data_nascimento) VALUES (:nome, :cpf, :dt_nasc)';

        $stmt = $connectionPdo->prepare($sql);
        $stmt->bindValue(':nome', $data['nome']);
        $stmt->bindValue(':cpf', $data['cpf']);
        $stmt->bindValue(':dt_nasc', $data['data_nascimento']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return 'Corredor inserido com sucesso!';
        } else {
            throw new \Exception("Não foi possível inserir Corredor.");
        }
    }
}
