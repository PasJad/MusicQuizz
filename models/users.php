<?php
require_once("./config/db.php");
class Users
{
    /**
     * Undocumented function
     *
     * @param [type] $pseudoUser
     * @param [type] $mailUser
     * @param [type] $mdpUser
     * @param [type] $statutUser
     * @return void
     */
    public function add($pseudoUser, $mailUser, $mdpUser, $statutUser)
    {
        // Init
        static $ps = null;
        $sql = 'INSERT INTO users (Pseudo,Email,Mdp,Statut) values (:pseudoUser,:mailUser,:mdpUser,:statutUser)';
        $flag = false;
        // Process
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':pseudoUser', $pseudoUser);
            $ps->bindParam(':mailUser', $mailUser);
            $ps->bindParam(':mdpUser', $mdpUser);
            $ps->bindParam(':statutUser', $statutUser);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = true;
            $codeErreur = $e->getCode();
            if ($codeErreur == 23000) {
                echo '<script>alert("Ce compte est déjà existant")</script>';
            }
        }
        // Output
        return $flag;
    }

    public function getAllUsers()
    {
        // Init
        $sql = "SELECT * FROM users";
        $ps = Database::getPDO()->query($sql);
        // Process
        try {
            $ps->execute();
            return $ps->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getUserPswdByMail($mailUser)
    {
        // Init
        static $ps = null;
        $sql = 'SELECT Mdp from users where Email = :mailUser';
        $flag = false;
        // Process
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':mailUser', $mailUser);
            $ps->execute();
            return $ps->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function getUserByMail($mailUser)
    {
        // Init
        static $ps = null;
        $sql = 'select * from users where Email = :mailUser';
        $flag = false;
        // Process
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':mailUser', $mailUser);
            $ps->execute();
            return $ps->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


}
