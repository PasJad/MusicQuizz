<!--
Nom : Tayan
Prénom : Jad
Ecole : CFPT-Informatique
Date : 23.04.2021
Projet : TPI 2021
Fichier : register.php
 -->
<html>
<head>
  <title>Inscription</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="./style/css/style.css">
</head>
<body>
  <div class="mainform">
    <form action="index.php?uc=register&action=inscription" method="post">
      <h1>Créer un compte</h1>
      <h3>Vous possédez déjà un compte ?</h3>
      <a href="./index.php?uc=login">Se connecter !</a>
      <input type="text" class="textboxform" placeholder="Pseudo" id="input1" name="pseudo" required />
      <input type="email" class="textboxform" placeholder="E-mail" id="input2" name="mail" required />
      <input type="password" class="textboxform" placeholder="Mot de passe" id="input3" name="mdp" required />
      <input type="submit" id="inscrire" placeholder="s'incrire" value="S'inscrire" name="submitRegister">
    </form>
  </div>
</body>
</html>