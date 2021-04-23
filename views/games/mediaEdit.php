<!--
Nom : Tayan
Prénom : Jad
Ecole : CFPT-Informatique
Date : 23.04.2021
Projet : TPI 2021
Fichier : mediaEdit.php
 -->
<html>

<head>
  <title>Editer une musique</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="../../style/css/style.css">
</head>

<body>
  <div class="mainform" id="mediaForm">
    <form action="index.php?uc=media&action=modifier&id=<?=$id?>" enctype="multipart/form-data" method="post">

      <input type="text" class="textboxform" placeholder="Nom de la musique" id="" name="nomMusique" value="<?= $monTitre[0]["TitreMusique"] ?>" required />
      <textarea name="description" class="textboxform" placeholder="description" id="descArea" value=""><?= $monTitre[0]["Description"] ?></textarea>
      <select name="optionsTypes" class="textboxform">
        <?php
        for ($i = 0; $i < count($mesOptionsTypes); $i++) {
          if ($mesOptionsTypes[$i]["IdType"] == $monTitre[0]["IdType"]) {
            echo "<option value='" . $monTitre[0]["IdType"] .  "' selected>"  . $mesOptionsTypes[$i]["Type"] . "</options>";
          }
          else{
            echo "<option value='" . $mesOptionsTypes[$i]["IdType"] .  "'>"  . $mesOptionsTypes[$i]["Type"] . "</options>";
          }
        }
        ?>
      </select>
      <input type="file" class="textboxform" id="" name="uploadMusique[]" accept="audio/mpeg,audio/ogg,audio/wav" required />
      <input type="file" class="textboxform" id="" name="uploadImage[]" accept="image/*" required />
      <input type="submit" id="inscrire" value="Modifier" name="submitEdit">
    </form>
  </div>
</body>

</html>