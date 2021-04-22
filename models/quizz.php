<?php
require_once("./config/db.php");
class Quizz
{
    /**
     * Ajoute une partie à la table quizz
     *
     * @param [type] $score
     * @return void
     */
    public function add($score)
    {
        // Init
        static $ps = null;
        $sql = 'INSERT INTO Quizz (Score) values (:score)';
        $flag = false;
        // Process
        if ($ps === null) {
            $ps = Database::getPDO()->prepare($sql);
        }
        try {
            $ps->bindParam(':score', $score);
            $flag = $ps->execute();
        } catch (PDOException $e) {
            $flag = false;
        }
        // Output
        return $flag;
    }
}
?>
