<!--
Nom : Tayan
Prénom : Jad
Ecole : CFPT-Informatique
Date : 23.04.2021
Projet : TPI 2021
Fichier : mediaTypeCreate.php
 -->
<html>
<head>
  <title>Ajouter un nouveau type</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="../../style/css/style.css">
</head>
<body>
  <div class="mainform" id="mediaTypeForm">
    <form action="index.php?uc=media&action=creeType" enctype="multipart/form-data" method="post">
      <input type="text" class="textboxform" placeholder="Nom du type de musique" id="" name="nomType" required />
      <input type="submit" id="inscrire" value="Créer" name="submitNew">
    </form>
  </div>
</body>
</html>