<!--
Nom : Tayan
Prénom : Jad
Ecole : CFPT-Informatique
Date : 23.04.2021
Projet : TPI 2021
Fichier : profilEdit.php
 -->
<html>

<head>
  <title>Modifier profil</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="./style/css/style.css">
</head>

<body>
  <div class="mainform" id="profilForm">
    <form action="index.php?uc=profil&action=modifier&id=<?=$id?>" enctype="multipart/form-data" method="post">

      <input type="text" class="textboxform" placeholder="Nom" id="" name="nomUser" value="<?= $userModify[0]['Nom'] ?>" required />
      <input type="text" class="textboxform" placeholder="Pseudo" id="" name="pseudoUser" value="<?= $userModify[0]['Pseudo'] ?>" required />
      <input type="mail" class="textboxform" placeholder="E-Mail" id="" name="mailUser" value="<?= $userModify[0]['Email'] ?>" required />
      <input type="password" class="textboxform" placeholder="******" id="" name="mdpUser" required />
      <input type="file" class="textboxform" id="" name="uploadImage[]" accept="image/*"/>
      <input type="submit" id="inscrire" value="Modifier" name="submitEdit">
    </form>
  </div>
</body>

</html>