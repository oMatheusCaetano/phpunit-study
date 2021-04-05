<?php

namespace PHPUnitStudy\Study\Infra;

class ConnectionCreator
{
    private static \PDO $pdo;

    public static function getConnection(): \PDO
    {
        if (is_null(self::$pdo)) {
            $databasePath = __DIR__ . '/../../data/database.sqlite';
            self::$pdo = new \PDO('sqlite:' . $databasePath);
            self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return self::$pdo;
    }
}
