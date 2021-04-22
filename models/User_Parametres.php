<?php
require_once("./config/db.php");
class User_Parametres
{

    public function add($IdParam, $IdUser)
    {
        // Init
        static $ps = null;
        $sql = 'INSERT INTO user_parametres (IdParametre,IdUser) values (:IdParam,:IdUser)';
        $flag = false;
        // Process
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':IdParam', $IdParam);
            $ps->bindParam(':IdUser', $IdUser);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = false;
        }
        // Output
        return $flag;
    }
}
