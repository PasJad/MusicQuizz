<html>

<head>
    <title>Accueil</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="../../style/css/style.css">
    <script src="../../style/js/app.js"></script>
</head>

<body>
    <form action="index.php?uc=media&action=nouveau" method="post">
        <div class="mediaContainer">
            
                <?php
                for ($i = 0; $i < count($mesTitres); $i++) {
                    echo "<div class='champsContainer'>";
                    echo "<div id='" . $mesTitres[$i]['IdMusique'] . "'" . ">" . $mesTitres[$i]['IdMusique'] . "</div>";
                    echo "<div id='" . $mesTitres[$i]['IdMusique'] . "'" . ">" . $mesTitres[$i]['TitreMusique'] . "</div>";
                    echo "<div id='" . $mesTitres[$i]['IdMusique'] . "'" . ">" . $mesTitres[$i]['Description'] . "</div>";
                    echo "<audio controls>";
                    echo "<source id='" . $mesTitres[$i]['IdMusique'] . "'" . "src='". $mesTitres[$i]['Musique'] . "'>";
                    echo "</audio>";
                    echo "<img id='" . $mesTitres[$i]['IdMusique'] . "'" . "src='" . $mesTitres[$i]['ImagePochette'] . "' width='60%' height='60%'>";
                    echo "</div>";
                }
                ?>

            <input type="submit" name="create" value="Nouveau!" id="btnNew">
        </div>
    </form>

</body>

</html>