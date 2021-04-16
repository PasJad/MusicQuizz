<html>
<head>
  <title>Accueil</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="../../style/css/style.css">
  <script src="../../style/js/app.js"></script>
</head>

<body>
  <div class="gameform">
    <form action="" method="post" class="formParam">
      <div class="paramContainer">
        <div>
          <div>
            <div class="sec23">
            <label for="slider" id="sec">Temps </label> 
            <label for="slider" id="sec2">13 secondes</label>
            </div>
            <input type="range" class="slider" name="slider" id="slider1" min="5" max="20" oninput="UpdateSlider(this.value)" />
          </div>
          <br>
          <select name="nbQuestion" class="selections">
            <option value="10"> 10 Questions </option>
            <option value="20"> 20 Questions </option>
            <option value="30"> 30 Questions </option>
          </select>
        </div>
        <br>
        <div class="choixType">
          
          <input type="radio" id="chant" name="type" value="chant"> <label for="chant">Chant</label> 
          <br>
          <input type="radio" id="image" name="type" value="image"> <label for="image">Image</label>
        </div>


      </div>
      <input type="submit" id="jouer" value="Lancer la partie" name="submitPlay">
      <div name="profil" value="" class="profilbutton" onclick="location.href='index.php?uc=profil'"> <?= $_SESSION['User']['0']['Pseudo'] ?>
        <a href="index.php?uc=login&action=deconnexion" name="deconnexion" value="Déconnexion" class="deconnexion">Déconnexion</a>
      </div>
    </form>
  </div>

</body>

</html>