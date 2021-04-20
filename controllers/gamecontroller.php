<?php

require_once("./models/Quizz.php");
require_once("./models/Musiques.php");

$titres = array();
$aDeviner = "";
$typePartie = "";
$ctrlg = new ControllerGame();


if ($action == "start" && !isset($_SESSION['game']['hasStarted'])) {

    $submit = filter_input(INPUT_POST, 'submitPlay', FILTER_SANITIZE_STRING);
    if ($submit && !isset($_SESSION['game'])) {
        $typePartie = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
        $nombrequestions = filter_input(INPUT_POST, 'nbQuestion', FILTER_SANITIZE_STRING);
        $temps = filter_input(INPUT_POST, 'slider', FILTER_SANITIZE_STRING);
        if (!empty($typePartie) && !empty($nombrequestions) && !empty($temps)) {
            $_SESSION['game'] = array();
            $_SESSION['game']['hasStarted'] = true;
            $_SESSION['game']['typePartie'] = $typePartie;
            $_SESSION['game']['nbQuestion'] = $nombrequestions;
            $_SESSION['game']['nbStep'] = 1;
            $_SESSION['game']['trueReponse'] = "";
            $_SESSION['game']['point'] = 0;
            $_SESSION['game']['timerMS'] = $temps * 100;
            $titres = $ctrlg->getFourQuestion();
            $aDeviner = $ctrlg->getStep($titres, $typePartie);
        }
    }
}
else{
    $action = "next";
}


if ($action == "next") {
    $reponsesentree = filter_input(INPUT_POST, 'reponses', FILTER_SANITIZE_STRING);
    $_SESSION['game']['nbStep'] += 1;
    if ($_SESSION['game']['nbStep'] > $_SESSION['game']['nbQuestion']) {
        if ($reponsesentree == $_SESSION['game']['trueReponse'][0]['IdMusique']) {
            $_SESSION['game']['point'] += 1;
        }
        $_SESSION['User']['Score'] = $_SESSION['game']['point'];
        unset($_SESSION['game']);
        header("Location: index.php?uc=accueil&action=score");
        exit();
    } else {
        if ($reponsesentree == $_SESSION['game']['trueReponse'][0]['IdMusique']) {
            $_SESSION['game']['point'] += 1;
        }
        $titres = $ctrlg->getFourQuestion();
        $aDeviner = $ctrlg->getStep($titres, $typePartie);
    }
}


require_once("./views/games/game.php");




class ControllerGame
{

    protected $mQuiz;
    protected $mMusic;

    public function __construct()
    {
        $this->mQuiz = new Quizz();
        $this->mMusic = new Musiques();
    }

    public function show()
    {
    }

    public function getFourQuestion()
    {
        $titres = array();
        $idDejaTire = array();
        $RND = 0;
        var_dump($this->mMusic->getNumberOfMusique());
        $nbMusique = $this->mMusic->getNumberOfMusique()['COUNT(*)'];
        while (count($titres) != 4) {
            $RND = rand(1, $nbMusique);
            if (!in_array($RND, $idDejaTire)) {
                $musiqueAQCM = $this->mMusic->getMusiqueById($RND);
                array_push($titres, $musiqueAQCM);
                array_push($idDejaTire, $RND);
            }
        }
        return $titres;
    }
    public function getStep($titres, $typePartie)
    {
        $RND = 0;
        $RND = rand(0, 3);
        $aDeviner = "";
        $_SESSION['game']['trueReponse'] = $titres[$RND];

        if ($_SESSION['game']['typePartie'] == "chant") {
            $aDeviner = "<audio autoplay id='player'>" . "<source src='" .  $titres[$RND][0]['Musique'] . "#t=". rand(20,50) ."'>"  . "</audio>";
        }
        if ($_SESSION['game']['typePartie'] == "image") {
            $aDeviner = "<img src='" . $titres[$RND][0]['ImagePochette'] . "' width='200px' height='200px'/>";
        }
        return $aDeviner;
    }

    public function StartGame($temps, $typePartie)
    {
        # code...
    }

    function edit()
    {
        return $this;
    }

    function delete()
    {
    }

    /**
     * Get the value of mUser
     */
    public function getMUser()
    {
        return $this->mUser;
    }

    /**
     * Set the value of mUser
     *
     * @return  self
     */
    public function setMUser($mUser)
    {
        $this->mUser = $mUser;

        return $this;
    }
}
