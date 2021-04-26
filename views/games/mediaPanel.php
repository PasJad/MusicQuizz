<!--
Nom : Tayan
Prénom : Jad
Ecole : CFPT-Informatique
Date : 23.04.2021
Projet : TPI 2021
Fichier : mediaPanel.php
 -->
<html>

<head>
    <title>Musiques</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="./style/css/style.css">
    <script src="./style/js/app.js"></script>
</head>

<body>
    <form action="index.php?uc=media&action=nouveau" method="post">
        <div class="mediaContainer">
            
                <?php
                for ($i = 0; $i < count($mesTitres); $i++) {
                    echo "<div class='champsContainer'>";
                    echo "<div class='champ' id='" . $mesTitres[$i]['IdMusique'] . "'" . ">" . $mesTitres[$i]['IdMusique'] . "</div>";
                    echo "<div class='champ' id='" . $mesTitres[$i]['IdMusique'] . "'" . ">" . $mesTitres[$i]['TitreMusique'] . "</div>";
                    echo "<div class='champ' id='" . "champDescription" . "'" . ">" . $mesTitres[$i]['Description'] . "</div>";
                    echo "<audio controls>";
                    echo "<source id='" . $mesTitres[$i]['IdMusique'] . "'" . "src='". $mesTitres[$i]['Musique'] . "' width='400px'>";
                    echo "</audio>";
                    echo "<img id='" . $mesTitres[$i]['IdMusique'] . "'" . "src='" . $mesTitres[$i]['ImagePochette'] . "' width='60%' height='60%'>";
                    echo "<a class='champ' id='BtnEdit' href='index.php?uc=media&action=edit&id=" . $mesTitres[$i]['IdMusique'] . "'>Edit</a>";
                    echo "</div>";
                }
                ?>

        </div>
        <a href="index.php?uc=accueil" id="btnHome">Home</a>
        <input type="submit" name="create" value="Nouveau!" id="btnNew">
    </form>

</body>

</html>