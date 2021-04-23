<?php
/**
  * Nom : Tayan
  * Prénom : Jad
  * Ecole : CFPT-Informatique
  * Date : 23.04.2021
  * Projet : TPI 2021
  * Fichier : Parametres.php
  */
require_once("./config/db.php");
class Parametres
{

    /**
     * Fonction modèle qui formule la requête pour récupérer les parametres pour un id user donnée 
     *
     * @param [int] $UserId
     * @return array
     */
    public function getParamByIdUser($UserId)
    {
        //Initialisation
        static $ps = null;
        $sql = "SELECT parametres.IdParametre,NbQuestions,Temps,TypePartie FROM parametres INNER JOIN user_parametres on parametres.IdParametre = user_parametres.IdParametre INNER JOIN users on user_parametres.IdUser = users.IdUser where  users.IdUser = :idUser";
        //Traitement
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        // Try catch pour attraper les erreur
        try {
            $ps->bindParam(':idUser', $UserId);
            $ps->execute();
            //Sortie
            return $ps->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
    /**
     * Fonction du modèle qui formule la requête pour ajouter un set de paramètre dans ma base
     *
     * @param [int] $NbQuestion
     * @param [int] $Temps
     * @param [string] $TypePartie
     * @param [int] $IdQuiz
     * @return bool
     */
    public function add($NbQuestion,$Temps,$TypePartie,$IdQuiz)
    {
        //Initialisation
        static $ps = null;
        $sql = 'INSERT INTO parametres (NbQuestions,Temps,TypePartie,IdQuizz) values (:NbQuestion,:Temps,:TypePartie,:IdQuiz)';
        $flag = false;
        //Traitement
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        // Try catch pour attraper les erreur
        try {
            $ps->bindParam(':NbQuestion', $NbQuestion);
            $ps->bindParam(':Temps', $Temps);
            $ps->bindParam(':TypePartie', $TypePartie);
            $ps->bindParam(':IdQuiz', $IdQuiz);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = false;
        }
        //Sortie
        return $flag;
    }

    /**
     * Fonction modèle qui formule la requête pour avoir tout les paramètres
     *
     * @return array
     */
    public function getAllParameters()
    {
        //Initialisation
        $sql = "SELECT * FROM parametres";
        $ps = Database::getPDO()->query($sql);
        //Traitement
        // Try catch pour attraper les erreur
        try {
            $ps->execute();
            //Sortie
            return $ps->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
}
