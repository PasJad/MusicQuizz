<html>

<head>
    <title>Accueil</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="../../style/css/style.css">
    <script src="../../style/js/app.js"></script>
</head>

<body>

    <div class="profilform">
        <div class="profilInfo">
        <img src="">
        </div>

        <div class="parties-titres">
        <span id="titreMesParties">Vos Parties :</span>
        <div class="mesParties">
            <?php
            for ($i = 0; $i < count($mesParties); $i++) {
                echo "<div class='partieContainer'>";
                echo "<div class='champ' id='" . $mesParties[$i]['IdQuiz'] . "'" . "> Quiz : " . $mesParties[$i]['IdMusique'] . "</div>";
                echo "<div class='champ' id='" . $mesParties[$i]['IdQuiz'] . "'" . "> Score : " . $mesParties[$i]['Score'] . "</div>";
                echo "</div>";
            }
            ?>
            <div class='partie' id="1">
                <div> Quiz : 1</div>
                <div> Score : 10</div>
            </div>
            <div class='partie' id="1">
                <div> Quiz : 1</div>
                <div> Score : 10</div>
            </div>
            <div class='partie' id="1">
                <div> Quiz : 1</div>
                <div> Score : 10</div>
            </div>
            <div class='partie' id="1">
                <div> Quiz : 1</div>
                <div> Score : 10</div>
            </div>
            <div class='partie' id="1">
                <div> Quiz : 1</div>
                <div> Score : 10</div>
            </div>
            <div class='partie' id="1">
                <div> Quiz : 1</div>
                <div> Score : 10</div>
            </div>
            <div class='partie' id="1">
                <div> Quiz : 1</div>
                <div> Score : 10</div>
            </div>
            <div class='partie' id="1">
                <div> Quiz : 1</div>
                <div> Score : 10</div>
            </div>
            <div class='partie' id="1">
                <div> Quiz : 1</div>
                <div> Score : 10</div>
            </div>
            
            </div>
        </div>

            <a href="index.php?uc=accueil" id="btnBack">Retour</a>
            <a href="index.php?uc=profil&action=edit&id=<?=$_SESSION['User'][0]['IdUser']?>" id="btnModifier"> </a>
    </div>
</body>

</html>