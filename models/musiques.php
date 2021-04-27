<?php
/**
  * Nom : Tayan
  * Prénom : Jad
  * Ecole : CFPT-Informatique
  * Date : 27.04.2021
  * Projet : TPI 2021
  * Fichier : Musiques.php
  */
require_once("./config/db.php");
class Musiques
{
    /**
     * Fonction modèle qui formule la requête pour ajouter une musique dans ma table
     *
     * @param [string] $pseudoUser
     * @param [string] $mailUser
     * @param [string] $mdpUser
     * @param [int] $statutUser
     * @return void
     */
    public function add($titreMusique, $descMusique, $mediaMusique, $imageMusique,$typeMusique)
    {
        //Initialisation
        static $ps = null;
        $sql = 'INSERT INTO musiques (TitreMusique,Description,Musique,ImagePochette,IdType) values (:titreMusique,:descMusique,:mediaMusique,:imageMusique,:typeMusique)';
        $flag = false;
        //Traitement
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':titreMusique', $titreMusique, PDO::PARAM_STR);
            $ps->bindParam(':descMusique', $descMusique, PDO::PARAM_STR);
            $ps->bindParam(':mediaMusique', $mediaMusique, PDO::PARAM_STR);
            $ps->bindParam(':imageMusique', $imageMusique, PDO::PARAM_STR);
            $ps->bindParam(':typeMusique', $typeMusique, PDO::PARAM_STR);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = false;
        }
        //Sortie
        return $flag;
    }
    

    /**
     * Fonction qui formule la requête pour récupérer toutes les musiques de ma table 
     *
     * @return array
     */
    public function getAllMusiques()
    {
        //Initialisation
        $flag = false;
        $sql = "SELECT IdMusique,TitreMusique,Description,Musique,ImagePochette,Type FROM musiques INNER JOIN typeMusiques on musiques.IdType = typeMusiques.IdType";
        $ps = Database::getPDO()->query($sql);
        //Traitement
        try {
            $ps->execute();
            $flag = $ps->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $flag = false;
        }
        return $flag;
    }

    /**
     * Fonction modèle qui formule la requête qui récupère le nombre de musiques de ma table
     *
     * @return array
     */
    public function getNumberOfMusique()
    {
        //Initialisation
        $flag = false;
        $sql = "SELECT COUNT(*) FROM musiques";
        //Traitement
        $ps = Database::getPDO()->query($sql);
        //Try Catch pour vérifier si on a pas eu d'erreurs lors de la requête
        try {
            $ps->execute();
            //Sortie
            $flag = $ps->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $flag = false;
        }
        return $flag;
    }

    /**
     * Fonction modèle qui s'occupe de formuler la requête pour modifier une musique dans la table à l'aide d'un id donnée
     *
     * @param [string] $titre
     * @param [string] $desc
     * @param [string] $mediasMusiques
     * @param [string] $mediasImages
     * @param [string] $type
     * @param [id] $idEditMusique
     * @return bool
     */
    public function updateMusique($titre, $desc, $mediasMusiques, $mediasImages, $type,$idEditMusique)
    {
        //Initialisation
        static $ps = null;
        $sql = 'UPDATE musiques set
        TitreMusique = :titreMusique,
        Description = :descMusique,
        Musique = :mediaMusique,
        ImagePochette = :imageMusique,
        IdType = :typeMusique WHERE IdMusique = :idEditMusique';
        $flag = false;
        //Traitement
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        //Try catch pour vérifier si on a une erreur
        try {
            $ps->bindParam(':titreMusique', $titre, PDO::PARAM_STR);
            $ps->bindParam(':descMusique', $desc, PDO::PARAM_STR);
            $ps->bindParam(':mediaMusique', $mediasMusiques, PDO::PARAM_STR);
            $ps->bindParam(':imageMusique', $mediasImages, PDO::PARAM_STR);
            $ps->bindParam(':typeMusique', $type, PDO::PARAM_STR);
            $ps->bindParam(':idEditMusique',$idEditMusique, PDO::PARAM_INT);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = false;
        }
        //Sortie
        return $flag;
    }

    /**
     * Fonction modèle qui s'occupe de formuler la requête pour récupérer une musique à l'aide d'un id
     *
     * @param [type] $idMusique
     * @return void
     */
    public function getMusiqueById($idMusique)
    {
        //Initialisation
        static $ps = null;
        $sql = 'select * from musiques where IdMusique = :IdMusique';
        $flag = false;
        //Traitement
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':IdMusique', $idMusique, PDO::PARAM_INT);
            $ps->execute();
            //Sortie
            $flag =  $ps->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $flag = false;
        }
        return $flag;
    }

    /**
     * Fonction modèle qui s'occupe de formuler la requête pour supprimer une musique dans la table
     *
     * @param [int] $idMusique
     * @return void
     */
    public function deleteMusiqueById($idMusique)
    {
        //Initialisation
        static $ps = null;
        $sql = 'DELETE FROM musiques where IdMusique = :IdMusique';
        $flag = false;
        //Traitement
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        //Try catch pour vérifier si nous n'avons pas eu d'erreur
        try {
            $ps->bindParam(':IdMusique', $idMusique, PDO::PARAM_INT);
            $ps->execute();
        } catch (PDOException $e) {
            //Sortie
            return $e->getCode();
        }
    }
}
