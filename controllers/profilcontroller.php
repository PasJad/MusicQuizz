<?php
require_once("./models/Users.php");
$mesParties = array();
if ($action == "edit") {
    require_once("./views/games/profilEdit.php");    
}
else {
    require_once("./views/games/profil.php");
}
