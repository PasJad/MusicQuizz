<!--
Nom : Tayan
Prénom : Jad
Ecole : CFPT-Informatique
Date : 23.04.2021
Projet : TPI 2021
Fichier : login.php
 -->
<html>

<head>
    <title>Connexion</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="./style/css/style.css">
</head>

<body>
<div class="mainform" id="loginform">
<form action="index.php?uc=login&action=connexion" method="post">
  <h1>Se connecter !</h1>
  <h3>Vous ne possédez pas un compte ?</h3>
  <a href="index.php?cu=register.php">Inscrivez vous !</a>
<input type="email" class="textboxform" placeholder="E-mail" id="input2" name="mail" required/>
<input type="password" placeholder="Mot de passe" class="textboxform" id="input3" name="mdp" required/>
<input type="submit" id="inscrire" placeholder="Se connecter !" value="Se connecter !" name="submitLogin">
</form>
</div>

</body>

</html>