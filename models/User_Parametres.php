<?php
/**
  * Nom : Tayan
  * Prénom : Jad
  * Ecole : CFPT-Informatique
  * Date : 23.04.2021
  * Projet : TPI 2021
  * Fichier : User_Parametres.php
  */
require_once("./config/db.php");
class User_Parametres
{

    /**
     * Fonction modèle qui formule une requête sql qui ajoute dans ma table de liaison
     *
     * @param [int] $IdParam
     * @param [int] $IdUser
     * @return void
     */
    public function add($IdParam, $IdUser)
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
            $ps->bindParam(':IdParam', $IdParam);
            $ps->bindParam(':IdUser', $IdUser);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = false;
        }
        //Sortie
        return $flag;
    }
}