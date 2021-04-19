<?php session_start(); ?>
<?php
require_once("./env.php");
$uc = filter_input(INPUT_GET, 'uc');
$action = filter_input(INPUT_GET, 'action');
$id = filter_input(INPUT_GET, 'id');

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
    case 'media':
        require_once("./controllers/musiccontroller.php");
        break;
    case 'game':
        require_once("./controllers/gamecontroller.php");
    }
?>
