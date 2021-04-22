<?php
require_once("./config/db.php");
class Parametres
{

    public function getParamByIdUser($UserId)
    {
        // Init
        static $ps = null;
        $sql = "SELECT parametres.IdParametre,NbQuestions,Temps,TypePartie FROM parametres INNER JOIN user_parametres on parametres.IdParametre = user_parametres.IdParametre INNER JOIN users on user_parametres.IdUser = users.IdUser where  users.IdUser = :idUser";
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        // Process
        try {
            $ps->bindParam(':idUser', $UserId);
            $ps->execute();
            return $ps->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
    /**
     * Fonction d'ajout dans la table parametres
     *
     * @param [type] $NbQuestion
     * @param [type] $Temps
     * @param [type] $TypePartie
     * @param [type] $IdQuiz
     * @return void
     */
    public function add($NbQuestion,$Temps,$TypePartie,$IdQuiz)
    {
        // Init
        static $ps = null;
        $sql = 'INSERT INTO parametres (NbQuestions,Temps,TypePartie,IdQuizz) values (:NbQuestion,:Temps,:TypePartie,:IdQuiz)';
        $flag = false;
        // Process
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':NbQuestion', $NbQuestion);
            $ps->bindParam(':Temps', $Temps);
            $ps->bindParam(':TypePartie', $TypePartie);
            $ps->bindParam(':IdQuiz', $IdQuiz);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = false;
        }
        // Output
        return $flag;
    }

    /**
     * Fonction qui nous retournes tout les parametres
     *
     * @return void
     */
    public function getAllParameters()
    {
        // Init
        $sql = "SELECT * FROM parametres";
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
