<?php
session_start();

if (isset($_SESSION["User"])) {
    var_dump($_SESSION["User"]);
}
else{
    header("Location: ../../views/games/Login.php");
    exit();
}
require_once("../../controllers/parameterscontroller.php");
$ctrlp = new ControllerParameters();
$ctrlp->show();

?>
