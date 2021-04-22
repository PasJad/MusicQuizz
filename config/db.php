<?php
class Database
{
    private static $pdo = null;
    /**
     * Returns PDO object
     * @return PDO|null
     */
    public static function getPDO()
    {

        $dbUsername = DB_USER;
        $dbPassword = DB_PASSWORD;
        $dbHostname = DB_HOST;
        $dbName = DB_NAME;

        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO('mysql:dbname=' . $dbName . ';host=' . $dbHostname, $dbUsername, $dbPassword, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                ]);
            } catch (PDOException $e) {
                echo 'Erreur : ' . $e->getMessage() . '<br />';
                echo 'N° : ' . $e->getCode();
                die('Could not connect to MySQL');
            }
        }

        return self::$pdo;
    }
}
