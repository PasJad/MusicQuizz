<?php
/**
  * Nom : Tayan
  * Prénom : Jad
  * Ecole : CFPT-Informatique
  * Date : 27.04.2021
  * Projet : TPI 2021
  * Fichier : User_Parametres.php
  */
require_once("./config/db.php");
class User_Parametres
{

    /**
     * Fonction modèle qui formule une requête sql qui ajoute dans ma table de liaison
     *
     * @param [int] $idParam
     * @param [int] $idUser
     * @return void
     */
    public function add($idParam, $idUser)
    {
        //Initialisation
        static $ps = null;
        $sql = 'INSERT INTO user_parametres (IdParametre,IdUser) values (:IdParam,:IdUser)';
        $flag = false;
        //Traitement
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        // Try catch pour attraper les erreur
        try {
            $ps->bindParam(':IdParam', $idParam, PDO::PARAM_INT);
            $ps->bindParam(':IdUser', $idUser, PDO::PARAM_INT);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = false;
        }
        //Sortie
        return $flag;
    }
}
