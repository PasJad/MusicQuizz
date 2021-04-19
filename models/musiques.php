<?php
require_once("./config/db.php");
class Musiques
{
    /**
     * Undocumented function
     *
     * @param [type] $pseudoUser
     * @param [type] $mailUser
     * @param [type] $mdpUser
     * @param [type] $statutUser
     * @return void
     */
    public function add($titreMusique, $descMusique, $mediaMusique, $imageMusique,$typeMusique)
    {
        // Init
        static $ps = null;
        $sql = 'INSERT INTO musiques (TitreMusique,Description,Musique,ImagePochette,IdType) values (:titreMusique,:descMusique,:mediaMusique,:imageMusique,:typeMusique)';
        $flag = false;
        // Process
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':titreMusique', $titreMusique);
            $ps->bindParam(':descMusique', $descMusique);
            $ps->bindParam(':mediaMusique', $mediaMusique);
            $ps->bindParam(':imageMusique', $imageMusique);
            $ps->bindParam(':typeMusique', $typeMusique);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = false;
            $codeErreur = $e->getCode();
        }
        // Output
        return $flag;
    }
    

    public function getAllMusiques()
    {
        // Init
        $sql = "SELECT IdMusique,TitreMusique,Description,Musique,ImagePochette,Type FROM musiques INNER JOIN typeMusiques on musiques.IdType = typeMusiques.IdType";
        $ps = Database::getPDO()->query($sql);
        // Process
        try {
            $ps->execute();
            return $ps->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function UpdateMusique($titre, $desc, $mediasMusiques, $mediasImages, $type,$idEditMusique)
    {
        // Init
        static $ps = null;
        $sql = 'UPDATE musiques set
        TitreMusique = :titreMusique,
        Description = :descMusique,
        Musique = :mediaMusique,
        ImagePochette = :imageMusique,
        IdType = :typeMusique WHERE IdMusique = :idEditMusique';
        $flag = false;
        // Process
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':titreMusique', $titre);
            $ps->bindParam(':descMusique', $desc);
            $ps->bindParam(':mediaMusique', $mediasMusiques);
            $ps->bindParam(':imageMusique', $mediasImages);
            $ps->bindParam(':typeMusique', $type);
            $ps->bindParam(':idEditMusique',$idEditMusique);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = false;
            $codeErreur = $e->getCode();
        }
        // Output
        return $flag;
    }

    public function getMusiqueById($idMusique)
    {
        // Init
        static $ps = null;
        $sql = 'select * from musiques where IdMusique = :IdMusique';
        $flag = false;
        // Process
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':IdMusique', $idMusique);
            $ps->execute();
            return $ps->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function deleteMusiqueById($idMusique)
    {
        // Init
        static $ps = null;
        $sql = 'DELETE FROM musiques where IdMusique = :IdMusique';
        $flag = false;
        // Process
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':IdMusique', $idMusique);
            $ps->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
