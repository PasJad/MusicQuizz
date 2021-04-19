<?php


$titres = "aaaaaaa";

$submit = filter_input(INPUT_POST, 'submitRegister', FILTER_SANITIZE_STRING);
$pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING);
$mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL);
$mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING);
$ctrlr = new ControllerRegister();

require_once("./models/Quizz.php");
require_once("./views/games/game.php");
?>