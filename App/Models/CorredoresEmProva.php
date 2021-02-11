<?php

namespace App\Models;

class CorredoresEmProva
{
    private static $table = 'corredores_em_prova';

    public static function selectAll()
    {
        $connectionPdo = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);

        $sql = 'SELECT * FROM ' . self::$table;

        $stmt = $connectionPdo->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("Nenhum Corredor em Prova.");
        }
    }

    public static function insert($data)
    {
        // $connectionPdo = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS);
        $connectionPdo = new \PDO(DBDRIVE . ': host=' . DBHOST . '; dbname=' . DBNAME, DBUSER, DBPASS, array(
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::MYSQL_ATTR_DIRECT_QUERY => false,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ));

        $sql = 'INSERT INTO ' . self::$table . '(id_corredor, id_prova) VALUES (:corredor, :prova)';

        $stmt = $connectionPdo->prepare($sql);
        $stmt->bindValue(':corredor', $data['id_corredor']);
        $stmt->bindValue(':prova', $data['id_prova']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return 'Corredor inserido na Prova com sucesso!';
        } else {
            throw new \Exception("Não foi possível inserir Corredor em Prova.");
        }
    }

    // public static function FunctionName(Type $var = null)
    // {
    //     # code...
    // }
}
