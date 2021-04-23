<?php
/**
  * Nom : Tayan
  * Prénom : Jad
  * Ecole : CFPT-Informatique
  * Date : 23.04.2021
  * Projet : TPI 2021
  * Fichier : TypeMusiques.php
  */
require_once("./config/db.php");
class Types
{
    /**
     * Fonction modèle qui formule une requête sql vas ajouter un nouveau type dans ma table
     *
     * @param [type] $type
     * @return void
     */
    public function add($type)
    {
        //Initialisation
        static $ps = null;
        $sql = 'INSERT INTO typemusiques (Type) values (:type)';
        $flag = false;
        //Traitement
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        // Try catch pour attraper les erreur
        try {
            $ps->bindParam(':type', $type);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = false;
            $codeErreur = $e->getCode();
        }
        //Sortie
        return $flag;
    }

    /**
     * Fonction modèle qui une requete sql pour supprimer un enregistrement dans ma table à l'aide de l'id
     *
     * @param [type] $typeId
     * @return void
     */
    public function deleteTypeById($typeId)
    {
        //Initialisation
        static $ps = null;
        $sql = 'DELETE FROM typemusiques where IdType = :IdType';
        $flag = false;
        //Traitement
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        // Try catch pour attraper les erreur
        try {
            $ps->bindParam(':IdType', $idMusique);
            $ps->execute();
        } catch (PDOException $e) {
            //Sortie
            return $e->getMessage();
        }
    }
    
    /**
     * Fonction modèle qui une requete sql qui récupére tout les types
     *
     * @return array
     */
    public function getAllOptions()
    {
        //Initialisation
        $sql = "SELECT IdType,Type FROM typemusiques";
        $ps = Database::getPDO()->query($sql);
        //Traitement
        try {
            $ps->execute();
            //Sortie
            return $ps->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Fonction modèle qui fait une requete sql pour modifier un type dans ma table
     *
     * @return void
     */
    public function UpdateTypeById($typeId,$type)
    {
        //Initialisation
        static $ps = null;
        $sql = 'UPDATE typemusiques set type = :type WHERE IdType = :idType';
        $flag = false;
        //Traitement
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        // Try catch pour attraper les erreur
        try {
            $ps->bindParam(':idType', $typeId);
            $ps->bindParam(':type',$type);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = false;
            $codeErreur = $e->getCode();
        }
        //Sortie
        return $flag;
    }
}
