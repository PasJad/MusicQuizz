<html>

<head>
    <title>Jouer !</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="../../style/css/style.css">
    <script src="../../style/js/app.js"></script>
</head>

<body>
    <div class="gameform">
        <div class="headband">Quel est cette musique ? : 1/10</div>
        <form action="index.php?uc=game&action=next" method="post" class="formParam">
        <audio id="player" src="sound.mp3"></audio>
            <div class="paramContainer">
            <input id="volume" type="range" min="1" max="100" value="30" id="myNumber">
                <div class="choixType">
                    <input type="radio" id="chant" name="type" value="chant"> <label for="chant"><?=$titres?></label>
                    <br>
                    <input type="radio" id="image" name="type" value="image"> <label for="image"><?=$titres?></label>
                    <br>
                    <input type="radio" id="chant" name="type" value="chant"> <label for="chant"><?=$titres?></label>
                    <br>
                    <input type="radio" id="image" name="type" value="image"> <label for="image"><?=$titres?></label>
                    <br>
                </div>
            </div>
            <input type="submit" id="jouer" value="Prochaine" name="submitPlay">
            <div name="profil" value="" class="profilbutton" onclick="location.href='index.php?uc=profil'"> <?= $_SESSION['User']['0']['Pseudo'] ?>
                <a href="index.php?uc=login&action=deconnexion" name="deconnexion" value="Déconnexion" class="deconnexion">Déconnexion</a>
            </div>
        </form>
    </div>

</body>

</html>