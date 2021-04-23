<!--
Nom : Tayan
Prénom : Jad
Ecole : CFPT-Informatique
Date : 23.04.2021
Projet : TPI 2021
Fichier : accueil.php
 -->
<html>
<head>
  <title>Accueil</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="../../style/css/style.css">
  <script src="../../style/js/app.js"></script>
</head>

<body>
  <div class="gameform">
    <form action="index.php?uc=game&action=start" method="post" class="formParam">
      <div class="paramContainer">
        <div>
          <div>
            <div class="sec23">
            <label for="slider" id="sec">Temps </label> 
            <label for="slider" id="sec2"><?=$vTemps?> secondes</label>
            </div>
            <?=$rangeSlider?>
          </div>
          <br>
          <select name="nbQuestion" class="selections">
            <?=$selected?>
          </select>
        </div>
        <br>
        <div class="choixType">
        <?=$choixDesTypes?>
          
        </div>


      </div>
      <div class="score-play">
        Vous avez eu un score de : <?=$score?> <br> 
      <input type="submit" id="jouer" value="Lancer la partie" name="submitPlay">
     </div>
      
      
      <div name="profil" value="" class="profilbutton" onclick="location.href='index.php?uc=profil'"> <?= $_SESSION['User']['0']['Pseudo'] ?>
        <a href="index.php?uc=login&action=deconnexion" name="deconnexion" value="Déconnexion" class="deconnexion">Déconnexion</a>
      </div>
    </form>
  </div>

<script>

</script>
</body>
</html>