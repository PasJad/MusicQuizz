<!--
Nom : Tayan
Prénom : Jad
Ecole : CFPT-Informatique
Date : 23.04.2021
Projet : TPI 2021
Fichier : profilCreate.php
 -->
<html>
<head>
  <title>Ajouter un nouvel utilisateur</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="./style/css/style.css">
</head>
<body>
  <div class="mainform" id="profilCreateForm">
    <form action="index.php?uc=profil&action=cree" enctype="multipart/form-data" method="post">
      
    <input type="text" class="textboxform" placeholder="Nom" id="" name="nomUser" value="" required />
      <input type="text" class="textboxform" placeholder="Pseudo" id="" name="pseudoUser" value="" required />
      <input type="mail" class="textboxform" placeholder="E-Mail" id="" name="mailUser" value="" required />
      <input type="password" class="textboxform" placeholder="******" id="" name="mdpUser" required />
      <input type="text" class="textboxform" placeholder="0" id="" name="statutUser" required />
      <input type="file" class="textboxform" id="" name="uploadImage[]" accept="image/*" required/>
      <input type="submit" id="inscrire" value="Créer" name="submitNew">
    </form>
  </div>
</body>
</html>