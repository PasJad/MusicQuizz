<?php
require_once("./config/db.php");
class Types
{
    /**
     * Fonction qui à l'aide d'une requête sql vas ajouter un nouveau type dans ma table
     *
     * @param [type] $type
     * @return void
     */
    public function add($type)
    {
        // Init
        static $ps = null;
        $sql = 'INSERT INTO typemusiques (Type) values (:type)';
        $flag = false;
        // Process
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':type', $type);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = false;
            $codeErreur = $e->getCode();
        }
        // Output
        return $flag;
    }

    /**
     * Fonction qui permet grace à une requete sql de supprimer un enregistrement dans ma table à l'aide de l'id
     *
     * @param [type] $typeId
     * @return void
     */
    public function deleteTypeById($typeId)
    {
        // Init
        static $ps = null;
        $sql = 'DELETE FROM typemusiques where IdType = :IdType';
        $flag = false;
        // Process
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':IdType', $idMusique);
            $ps->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
    /**
     * Fonction qui permet à l'aide d'une requete sql de récupérer tout les types
     *
     * @return void
     */
    public function getAllOptions()
    {
        // Init
        $sql = "SELECT IdType,Type FROM typemusiques";
        $ps = Database::getPDO()->query($sql);
        // Process
        try {
            $ps->execute();
            return $ps->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
    /**
     * Fonction qui fait une requete sql pour modifier un type dans ma table
     *
     * @return void
     */
    public function UpdateTypeById($typeId,$type)
    {
        // Init
        static $ps = null;
        $sql = 'UPDATE typemusiques set type = :type WHERE IdType = :idType';
        $flag = false;
        // Process
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':idType', $typeId);
            $ps->bindParam(':type',$type);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = false;
            $codeErreur = $e->getCode();
        }
        // Output
        return $flag;
    }
}
