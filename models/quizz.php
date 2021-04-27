<?php
/**
  * Nom : Tayan
  * Prénom : Jad
  * Ecole : CFPT-Informatique
  * Date : 27.04.2021
  * Projet : TPI 2021
  * Fichier : Quizz.php
  */
require_once("./config/db.php");
class Quizz
{
    /**
     * Fonction modèle qui formule la requête pour ajouter un quiz a ma table
     *
     * @param [type] $score
     * @return void
     */
    public function add($score)
    {
        //Initialisation
        static $ps = null;
        $sql = 'INSERT INTO Quizz (Score) values (:score)';
        $flag = false;
        //Traitement
        // Try catch pour attraper les erreurs
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':score', $score, PDO::PARAM_INT);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = false;
        }
        //Sortie
        return $flag;
    }

}
?>
