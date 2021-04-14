<?php
require_once("./config/db.php");
class Parametres
{
    /**
     * Undocumented function
     *
     * @param [string] $paramName
     * @return void
     */
    public function add($paramName)
    {
        // Init
        static $ps = null;
        $sql = 'INSERT INTO parametres (NomParametre) values (:paramName)';
        $flag = false;
        // Process
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':paramName', $paramName);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = false;
        }
        // Output
        return $flag;
    }

    public function getAllParameters()
    {
        // Init
        $sql = "SELECT * FROM parametres";
        $ps = Database::getPDO()->query($sql);
        // Process
        try {
            $ps->execute();
            return $ps->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
}
