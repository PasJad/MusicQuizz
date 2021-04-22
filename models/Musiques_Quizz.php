<?php
require_once("./config/db.php");
class Musiques_Quizz
{

    public function add($IdMusique, $IdQuizz)
    {
        // Init
        static $ps = null;
        $sql = 'INSERT INTO musiques_quizz (IdMusique,IdQuizz) values (:IdMusique,:IdQuizz)';
        $flag = false;
        // Process
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':IdMusique', $IdMusique);
            $ps->bindParam(':IdQuizz', $IdQuizz);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = false;
        }
        // Output
        return $flag;
    }
}
