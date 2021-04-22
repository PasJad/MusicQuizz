<html>

<head>
    <title>Jouer !</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="../../style/css/style.css">
    <script src="../../style/js/app.js"></script>
</head>

<body onload="setTimeout(NextMusic,<?=$_SESSION['game']['timerMS'] * 10?>)">
    <div class="gameform">
        <div class="headband">Quel est cette musique ? : <?=$_SESSION['game']['nbStep']?> / <?=$_SESSION['game']['nbQuestion']?></div>
        <form id='formGame' action="index.php?uc=game&action=next" method="post" class="formParam">
            <div class="paramContainer">
                <div class="slider-img">
                    <input id="volume" type="range" min="1" max="100" value="30" id="myNumber" oninput="UpdateVolume(this.value)">
                    <?=$aDeviner?>
                </div>
                <div class="choixType">
                    <input type="radio" id="1" name="reponses" <?='value="' . $titres[0][0]['IdMusique']  . '"' ?> name="type" value="chant"> <label for="1"><?=$titres[0][0]['TitreMusique']?></label>
                    <br>
                    <input type="radio" id="2" name="reponses" <?='value="' . $titres[1][0]['IdMusique']  . '"' ?>> <label for="2"><?=$titres[1][0]['TitreMusique']?></label>
                    <br>
                    <input type="radio" id="3" name="reponses" <?='value="' . $titres[2][0]['IdMusique']  . '"' ?>> <label for="3"><?=$titres[2][0]['TitreMusique']?></label>
                    <br>
                    <input type="radio" id="4" name="reponses" <?='value="' . $titres[3][0]['IdMusique']  . '"' ?>> <label for="4"><?=$titres[3][0]['TitreMusique']?></label>
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