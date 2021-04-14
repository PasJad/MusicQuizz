<?php
require_once("./controllers/registercontroller.php");
if(isset($_SESSION["User"]))
{
  header("Location: ./game.php");
  exit();
} 
$submit = filter_input(INPUT_POST, 'submitRegister', FILTER_SANITIZE_STRING);
$pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING);
$mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL);
$mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING);
$ctrlr = new ControllerRegister();
if (isset($submit)) {
  if (!empty($pseudo) && !empty($mail) && !empty($mdp)) {
    $ctrlr->create($pseudo,$mail,$mdp,0);
  }
}

?>
<html>
<head>
  <title><?=$_GET["view"];?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="../../style/css/style.css">
</head>
<body>
<div class="mainform">
<form action="#" method="post">
  <h1>Créer un compte</h1>
  <h3>Vous possédez déjà un compte ?</h3>
  <a href="login.php">Se connecter !</a>
<input type="text" placeholder="Pseudo" id="input1" name="pseudo" required/>
<input type="text" placeholder="E-mail" id="input2" name="mail" required/>
<input type="password" placeholder="Mot de passe" id="input3" name="mdp" required/>
<input type="submit" id="inscrire" placeholder="s'incrire" value="S'inscrire" name="submitRegister">
</form>
</div>

</body>
</html>