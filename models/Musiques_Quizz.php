<?php
/**
  * Nom : Tayan
  * Prénom : Jad
  * Ecole : CFPT-Informatique
  * Date : 23.04.2021
  * Projet : TPI 2021
  * Fichier : Musiques_Quizz.php
  */
require_once("./config/db.php");
class Musiques_Quizz
{

    /**
     * Fonction modèle qui s'occupe de faire la requête d'ajout dans la table de liaison Musique et Quizz
     *
     * @param [int] $IdMusique
     * @param [int] $IdQuizz
     * @return bool
     */
    public function add($IdMusique, $IdQuizz)
    {
        //Initialisation
        static $ps = null;
        $sql = 'INSERT INTO musiques_quizz (IdMusique,IdQuizz) values (:IdMusique,:IdQuizz)';
        $flag = false;
        //Traitement
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        //Try catch pour vérifier que la requête c'est bien executé
        try {
            $ps->bindParam(':IdMusique', $IdMusique, PDO::PARAM_INT);
            $ps->bindParam(':IdQuizz', $IdQuizz, PDO::PARAM_INT);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            return $e->getCode();
        }
        //Sortie
        return $flag;
    }
}
