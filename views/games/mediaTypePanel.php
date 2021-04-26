<!--
Nom : Tayan
Prénom : Jad
Ecole : CFPT-Informatique
Date : 23.04.2021
Projet : TPI 2021
Fichier : mediaTypePanel.php
 -->
<html>

<head>
    <title>Types</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="../../style/css/style.css">
    <script src="../../style/js/app.js"></script>
</head>

<body>
    <form action="index.php?uc=media&action=nouveauType" method="post">
        <div class="mediaContainer">
            
                <?php
                for ($i = 0; $i < count($mesTypes); $i++) {
                    echo "<div class='champsContainer'>";
                    echo "<div class='champ' id='" . $mesTypes[$i]['IdType'] . "'" . ">" . $mesTypes[$i]['IdType'] . "</div>";
                    echo "<div class='champ' id='" . $mesTypes[$i]['Type'] . "'" . ">" . $mesTypes[$i]['Type'] . "</div>";
                    echo "<a class='champ' id='BtnEdit' href='index.php?uc=media&action=editType&id=" . $mesTypes[$i]['IdType'] . "'>Edit</a>";
                    echo "</div>";
                }
                ?>
        </div>
        <input type="submit" name="create" value="Nouveau!" id="btnNew">
    </form>

</body>

</html>