<?php

namespace App\Factories;

use PDO;
use PDOException;

class PDOFactory
{
    private static PDO $pdo;

    public static function create(): PDO
    {
        if (!empty(self::$pdo)) {
            return self::$pdo;
        }

        $dsn = 'pgsql:host=postgres;port=5432;dbname=postgres';
        $user = 'postgres';
        $password = '@postgres';

        try {
            $pdo = new PDO($dsn, $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$pdo = $pdo;
        } catch (PDOException $e) {
            die("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }

        return self::$pdo;
    }
}
