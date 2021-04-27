<?php
/**
  * Nom : Tayan
  * Prénom : Jad
  * Ecole : CFPT-Informatique
  * Date : 27.04.2021
  * Projet : TPI 2021
  * Fichier : Parametres.php
  */
require_once("./config/db.php");
class Parametres
{

    /**
     * Fonction modèle qui formule la requête pour récupérer les parametres pour un id user donnée 
     *
     * @param [int] $userId
     * @return array
     */
    public function getParamByIdUser($userId)
    {
        //Initialisation
        static $ps = null;
        $flag = false;
        $sql = "SELECT parametres.IdParametre,NbQuestions,Temps,TypePartie FROM parametres INNER JOIN user_parametres on parametres.IdParametre = user_parametres.IdParametre INNER JOIN users on user_parametres.IdUser = users.IdUser where  users.IdUser = :idUser";
        //Traitement
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        // Try catch pour attraper les erreur
        try {
            $ps->bindParam(':idUser', $userId, PDO::PARAM_INT);
            $ps->execute();
            //Sortie
            $flag = $ps->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $flag = false;
        }
        return $flag;
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
    public function add($nbQuestion,$temps,$typePartie,$idQuiz)
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
            $ps->bindParam(':NbQuestion', $nbQuestion, PDO::PARAM_INT);
            $ps->bindParam(':Temps', $temps, PDO::PARAM_INT);
            $ps->bindParam(':TypePartie', $typePartie, PDO::PARAM_STR);
            $ps->bindParam(':IdQuiz', $idQuiz, PDO::PARAM_INT);
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
        $flag = false;
        $sql = "SELECT * FROM parametres";
        $ps = Database::getPDO()->query($sql);
        //Traitement
        // Try catch pour attraper les erreur
        try {
            $ps->execute();
            //Sortie
            $flag = $ps->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $flag = false;
        }
        return $flag;
    }
}
