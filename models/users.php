<?php
/**
  * Nom : Tayan
  * Prénom : Jad
  * Ecole : CFPT-Informatique
  * Date : 27.04.2021
  * Projet : TPI 2021
  * Fichier : Users.php
  */
require_once("./config/db.php");
class Users
{
    /**
     * Fonction modèle qui formule une requête pour ajouter uniquement les information nécessaire dans la table
     *
     * @param [string] $pseudoUser
     * @param [string] $mailUser
     * @param [string] $mdpUser
     * @param [int] $statutUser
     * @return void
     */
    public function add($pseudoUser, $mailUser, $mdpUser, $statutUser)
    {
        //Initialisation
        static $ps = null;
        $sql = 'INSERT INTO users (Pseudo,Email,Mdp,Statut) values (:pseudoUser,:mailUser,:mdpUser,:statutUser)';
        $flag = false;
        //Traitement
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        // Try catch pour attraper les erreur
        try {
            $ps->bindParam(':pseudoUser', $pseudoUser, PDO::PARAM_STR);
            $ps->bindParam(':mailUser', $mailUser, PDO::PARAM_STR);
            $ps->bindParam(':mdpUser', $mdpUser, PDO::PARAM_STR);
            $ps->bindParam(':statutUser', $statutUser, PDO::PARAM_INT);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = false;
            $codeErreur = $e->getCode();
            if ($codeErreur == 23000) {
                echo '<script>alert("Ce compte est déjà existant")</script>';
            }
        }
        //Sortie
        return $flag;
    }

    /**
     * Fonction modèle qui formule une requête pour ajouter dans ma table un utilisateur et manière complète
     *
     * @param [string] $nom
     * @param [string] $pseudoUser
     * @param [string] $mailUser
     * @param [string] $mdpUser
     * @param [id] $statutUser
     * @param [string] $imgPath
     * @return void
     */
    public function addCompleteUser($nom,$pseudoUser, $mailUser, $mdpUser, $statutUser,$imgPath)
    {
        //Initialisation
        static $ps = null;
        $sql = 'INSERT INTO users (Pseudo,Nom,Email,Mdp,Avatar,Statut) values (:pseudoUser,:nomUser,:mailUser,:mdpUser,:imgPath,:statutUser)';
        $flag = false;
        //Traitement
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        // Try catch pour attraper les erreur
        try {
            $ps->bindParam(':nomUser', $nom, PDO::PARAM_STR);
            $ps->bindParam(':pseudoUser', $pseudoUser, PDO::PARAM_STR);
            $ps->bindParam(':mailUser', $mailUser, PDO::PARAM_STR);
            $ps->bindParam(':mdpUser', $mdpUser, PDO::PARAM_STR);
            $ps->bindParam(':statutUser', $statutUser, PDO::PARAM_INT);
            $ps->bindParam(':imgPath',$imgPath, PDO::PARAM_STR);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = false;
            $codeErreur = $e->getCode();
            if ($codeErreur == 23000) {
                echo '<script>alert("Ce compte est déjà existant")</script>';
            }
        }
        //Sortie
        return $flag;
    }

    /**
     * Fonction modèle qui formule la requête pour modifier un utilisateur avec un id donné
     *
     * @param [int] $idUser
     * @param [string] $nom
     * @param [string] $pseudo
     * @param [string] $mail
     * @param [string] $pwd
     * @param [string] $img
     * @return void
     */
    public function updateUser($idUser,$nom,$pseudo,$mail,$pwd,$img)
    {
        //Initialisation
        static $ps = null;
        $sql = 'UPDATE users set
        Nom = :nom,
        Pseudo = :pseudo,
        Email = :mail,
        Mdp = :pwd,
        Avatar = :img WHERE IdUser = :idUser';
        $flag = false;
        //Traitement
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            $ps->bindParam(':nom', $nom, PDO::PARAM_STR);
            $ps->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
            $ps->bindParam(':mail', $mail, PDO::PARAM_STR);
            $ps->bindParam(':pwd', $pwd, PDO::PARAM_STR);
            $ps->bindParam(':img',$img, PDO::PARAM_STR);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = false;
            return $e->getCode();
        }
        //Sortie
        return $flag;
    }

    /**
     * Fonction modèle qui formule une requête pour récupérer tout les utilisateurs de la table
     *
     * @return array
     */
    public function getAllUsers()
    {
        //Initialisation
        $sql = "SELECT * FROM users";
        $flag = false;
        $ps = Database::getPDO()->query($sql);
        //Traitement
        try {
            $ps->execute();
            //Sortie
            $flag = $ps->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $flag = false;
        }
        return $flag;
    }

    /**
     * Fonction modèle qui formule la requête pour récupérer un mot de passe pour un mail donnée
     *
     * @param [string] $mailUser
     * @return array
     */
    public function getUserPswdByMail($mailUser)
    {
        //Initialisation
        static $ps = null;
        $sql = 'SELECT Mdp from users where Email = :mailUser';
        $flag = false;
        //Traitement
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        // Try catch pour attraper les erreur
        try {
            $ps->bindParam(':mailUser', $mailUser,PDO::PARAM_STR);
            $ps->execute();
            //Sortie
            $flag = $ps->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $flag = false;
        }
        return $flag;
    }

    /**
     * Fonction modèle qui formule la requête qui récupère un user pour un mail donné
     *
     * @param [string] $mailUser
     * @return void
     */
    public function getUserByMail($mailUser)
    {
        //Initialisation
        static $ps = null;
        $sql = 'select * from users where Email = :mailUser';
        $flag = false;
        //Traitement
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        // Try catch pour attraper les erreur
        try {
            $ps->bindParam(':mailUser', $mailUser,PDO::PARAM_STR);
            $ps->execute();
            //Sortie
            $flag = $ps->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $flag = false;
        }
        return $flag;
    }

    /**
     * Fonction modèle qui formule une requête pour récupérer un user pour un id donnée
     *
     * @param [int] $Id
     * @return void
     */
    public function getUserById($id)
    {
        //Initialisation
        static $ps = null;
        $sql = 'select * from users where IdUser = :IdUser';
        $flag = false;
        //Traitement
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        // Try catch pour attraper les erreur
        try {
            $ps->bindParam(':IdUser', $id,PDO::PARAM_STR);
            $ps->execute();
            //Sortie
            $flag = $ps->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $flag = false;
        }
        return $flag;
    }

    /**
     * Fonction modèle qui formule la requête qui récupère tout les quiz pour un id donnée
     *
     * @param [int] $id
     * @return void
     */
    public function getAllQuizFromUserId($id)
    {
         //Initialisation
         static $ps = null;
         $sql = "SELECT Quizz.IdQuizz,Quizz.Score FROM users 
         INNER JOIN user_parametres on users.IdUser = user_parametres.IdUser 
         INNER JOIN parametres on parametres.IdParametre = user_parametres.IdParametre 
         INNER JOIN quizz on quizz.IdQuizz = parametres.IdQuizz where users.IdUser = :IdUser";
         $flag = false;
         //Traitement
         if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);    
         }
         // Try catch pour attraper les erreur
         try {
            $ps->bindParam(':IdUser', $id,PDO::PARAM_INT);
             $ps->execute();
             //Sortie
             $flag = $ps->fetchAll(PDO::FETCH_ASSOC);
         } catch (PDOException $e) {
             $flag = false;
         }
         return $flag;
    }
    /**
     * Fonction modèle qui formule la requête pour supprimer un utilisateur de ma table pour un id donnée
     *
     * @param [int] $id
     * @return void
     */
    public function deleteUserById($id)
    {
        //Initialisation
        static $ps = null;
        $sql = 'DELETE FROM users where IdUser = :IdUser';
        $flag = false;
        //Traitement
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        // Try catch pour attraper les erreur
        try {
            $ps->bindParam(':IdUser', $id,PDO::PARAM_STR);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            //Sortie (En cas d'erreur)
            $flag = false;
        }
        return $flag;
    }


}
