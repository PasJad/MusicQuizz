<?php
require_once("./config/db.php");
class Types
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
}
