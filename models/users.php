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

    public function addCompleteUser($nom,$pseudoUser, $mailUser, $mdpUser, $statutUser,$imgPath)
    {
        // Init
        static $ps = null;
        $sql = 'INSERT INTO users (Pseudo,Nom,Email,Mdp,Avatar,Statut) values (:pseudoUser,:nomUser,:mailUser,:mdpUser,:imgPath,:statutUser)';
        $flag = false;
        // Process
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':nomUser', $nom);
            $ps->bindParam(':pseudoUser', $pseudoUser);
            $ps->bindParam(':mailUser', $mailUser);
            $ps->bindParam(':mdpUser', $mdpUser);
            $ps->bindParam(':statutUser', $statutUser);
            $ps->bindParam(':imgPath',$imgPath);
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

    /**
     * Fonction qui vas modifier un utilisateur avec un id donné
     *
     * @param [type] $idUser
     * @param [type] $nom
     * @param [type] $pseudo
     * @param [type] $mail
     * @param [type] $pwd
     * @param [type] $img
     * @return void
     */
    public function UpdateUser($idUser,$nom,$pseudo,$mail,$pwd,$img)
    {
        // Init
        static $ps = null;
        $sql = 'UPDATE users set
        Nom = :nom,
        Pseudo = :pseudo,
        Email = :mail,
        Mdp = :pwd,
        Avatar = :img WHERE IdUser = :idUser';
        $flag = false;
        // Process
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':idUser', $idUser);
            $ps->bindParam(':nom', $nom);
            $ps->bindParam(':pseudo', $pseudo);
            $ps->bindParam(':mail', $mail);
            $ps->bindParam(':pwd', $pwd);
            $ps->bindParam(':img',$img);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = false;
            $codeErreur = $e->getCode();
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

    public function getUserById($Id)
    {
        // Init
        static $ps = null;
        $sql = 'select * from users where IdUser = :IdUser';
        $flag = false;
        // Process
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':IdUser', $Id);
            $ps->execute();
            return $ps->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public function getAllQuizFromUserId($id)
    {
         // Init
         static $ps = null;
         $sql = "SELECT Quizz.IdQuizz,Quizz.Score FROM users 
         INNER JOIN user_parametres on users.IdUser = user_parametres.IdUser 
         INNER JOIN parametres on parametres.IdParametre = user_parametres.IdParametre 
         INNER JOIN quizz on quizz.IdQuizz = parametres.IdQuizz where users.IdUser = :IdUser";
         $flag = false;
         if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);    
         }
         // Process
         try {
            $ps->bindParam(':IdUser', $id);
             $ps->execute();
             return $ps->fetchAll(PDO::FETCH_ASSOC);
         } catch (PDOException $e) {
             return null;
         }
    }

    public function deleteUserById($id)
    {
        // Init
        static $ps = null;
        $sql = 'DELETE FROM users where IdUser = :IdUser';
        $flag = false;
        // Process
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':IdUser', $id);
            $ps->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


}
