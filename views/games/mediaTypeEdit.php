<html>
<head>
  <title>Ajouter une nouvelle musique</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="../../style/css/style.css">
</head>
<body>
  <div class="mainform" id="mediaTypeForm">
    <form action="index.php?uc=media&action=modifierType&id=<?=$id?>" enctype="multipart/form-data" method="post">
      <input type="text" class="textboxform" placeholder="Nom du type de musique" id="" name="nomType" required />
      <input type="submit" id="inscrire" value="Modifier" name="submitEdit">
    </form>
  </div>
</body>
</html>