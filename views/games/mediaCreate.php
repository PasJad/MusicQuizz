<html>
<head>
  <title>Ajouter une nouvelle musique</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="../../style/css/style.css">
</head>
<body>
  <div class="mainform" id="mediaForm">
    <form action="index.php?uc=media&action=cree" enctype="multipart/form-data" method="post">
      
      <input type="text" class="textboxform" placeholder="Nom de la musique" id="" name="nomMusique" required />
      <textarea name="description"  class="textboxform" placeholder="description" id="descArea"></textarea>
      <select name="optionsTypes" class="textboxform">
      <?php
       for ($i = 0; $i < count($mesOptionsTypes); $i++) {
        echo "<option value='" . $mesOptionsTypes[$i]["IdType"] .  "'>"  . $mesOptionsTypes[$i]["Type"] . "</options>";
    }
      ?>
      </select>
      <input type="file" class="textboxform" id="" name="uploadMusique[]" accept="audio/mp3,audio/ogg,audio/wav" required />
      <input type="file" class="textboxform" id="" name="uploadImage[]" accept="image/*" required />
      <input type="submit" id="inscrire" value="Créer" name="submitNew">
    </form>
  </div>
</body>
</html>