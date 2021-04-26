<!--
Nom : Tayan
Prénom : Jad
Ecole : CFPT-Informatique
Date : 23.04.2021
Projet : TPI 2021
Fichier : userPanel.php
 -->
<html>

<head>
    <title>Panel Utilisateurs</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" href="./style/css/style.css">
    <script src="./style/js/app.js"></script>
</head>

<body>
    <form action="index.php?uc=profil&action=nouveau" method="post">
        <div class="mediaContainer">
            
                <?php
                for ($i = 0; $i < count($mesUsers); $i++) {
                    echo "<div class='champsContainer'>";
                    echo "<div class='champ' id='" . $mesUsers[$i]['IdUser'] . "'" . ">" . $mesUsers[$i]['IdUser'] . "</div>";
                    echo "<div class='champ' id='" . $mesUsers[$i]['IdUser'] . "'" . ">" . $mesUsers[$i]['Nom'] . "</div>";
                    echo "<div class='champ' id='" . $mesUsers[$i]['IdUser'] . "'" . ">" . $mesUsers[$i]['Pseudo'] . "</div>";
                    echo "<div class='champ' id='" . $mesUsers[$i]['IdUser'] . "'" . ">" . $mesUsers[$i]['Email'] . "</div>";
                    echo "<div class='champ' placeholder='Mot de passe' id='" . $mesUsers[$i]['IdUser'] . "'" . ">"  . "</div>";
                    echo "<div class='champ' id='" . $mesUsers[$i]['IdUser'] . "'" . ">" . $mesUsers[$i]['Statut'] . "</div>";
                    echo "<a class='champ' id='BtnEdit' href='index.php?uc=profil&action=edit&id=" . $mesUsers[$i]['IdUser'] . "'>Edit</a>";
                    echo "<a class='champ' id='BtnDelete' href='index.php?uc=profil&action=delete&id=" . $mesUsers[$i]['IdUser'] . "'>Delete</a>";
                    echo "</div>";
                }
                ?>

        </div>
        <a href="index.php?uc=accueil" id="btnHome">Home</a>
        <input type="submit" name="create" value="Nouveau!" id="btnNew">
    </form>

</body>

</html>