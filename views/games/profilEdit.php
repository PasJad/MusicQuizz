<html>

<head>
  <title>Modifier son profil</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="../../style/css/style.css">
</head>

<body>
  <div class="mainform" id="profilForm">
    <form action="index.php?uc=profil&action=modifier&id=<?=$id?>" enctype="multipart/form-data" method="post">

      <input type="text" class="textboxform" placeholder="Nom" id="" name="nomMusique" value="<?= $_SESSION["User"][0]['Nom'] ?>" required />
      <input type="text" class="textboxform" placeholder="Pseudo" id="" name="nomMusique" value="<?= $_SESSION["User"][0]['Pseudo'] ?>" required />
      <input type="mail" class="textboxform" placeholder="E-Mail" id="" name="nomMusique" value="<?= $_SESSION["User"][0]['Email'] ?>" required />
      <input type="password" class="textboxform" placeholder="******" id="" name="nomMusique" required />
      <input type="file" class="textboxform" id="" name="uploadImage[]" accept="image/*" required />
      <input type="submit" id="inscrire" value="Modifier" name="submitEdit">
    </form>
  </div>
</body>

</html>