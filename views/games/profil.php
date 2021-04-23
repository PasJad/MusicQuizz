<!--
Nom : Tayan
Prénom : Jad
Ecole : CFPT-Informatique
Date : 23.04.2021
Projet : TPI 2021
Fichier : profil.php
 -->
<html>

<head>
    <title>Profil</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="../../style/css/style.css">
    <script src="../../style/js/app.js"></script>
</head>

<body>
    <?=$AdminBanner?>
    
    <div class="profilform">
        <div class="profilInfo">
            <img class="profilPic" src="<?= $_SESSION['User'][0]['Avatar'] ?>">
            <div id='profilTicket'>
                <span id="profilName"><?= $_SESSION['User'][0]['Pseudo'] ?></span>
                <span id="profilScore">Score : <?= $scoreTotal //$scoreTotal
                                                ?> </span>
            </div>
        </div>

        <div class="parties-titres">
            <span id="titreMesParties">Vos Parties :</span>
            <div class="mesParties">
                <?php
                for ($i = 0; $i < count($mesParties); $i++) {
                    echo "<div class='partie'>";
                    echo "<div id='" . $mesParties[$i]['IdQuizz'] . "'" . "> Quiz : " . $mesParties[$i]['IdQuizz'] . "</div>";
                    echo "<div id='" . $mesParties[$i]['IdQuizz'] . "'" . "> Score : " . $mesParties[$i]['Score'] . "</div>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>

        <a href="index.php?uc=accueil" id="btnBack">Retour</a>
        <a href="index.php?uc=profil&action=edit&id=<?= $_SESSION['User'][0]['IdUser'] ?>" id="btnModifier">Modifier</a>
    </div>
</body>

</html>