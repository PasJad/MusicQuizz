<?php session_start(); ?>
<?php
require_once("./env.php");
$uc = filter_input(INPUT_GET,'uc');
$action = filter_input(INPUT_GET,'action');

switch ($uc) {
    default:
        require_once("./controllers/registercontroller.php");
        break;
    case 'accueil':
        require_once("./controllers/parameterscontroller.php");
        break;
    case 'register':
        require_once("./controllers/registercontroller.php");
        break;
    case 'login':
        require_once("./controllers/logincontroller.php");
        break;
    case 'game':
        // TODO require_once("./views/games/game.php");
        break;
}

?>
