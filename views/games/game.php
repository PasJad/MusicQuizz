<?php
require_once("./controllers/parameterscontroller.php");
echo "a2";
$ctrlp = new ControllerParameters();
$ctrlp->show();
if (isset($_POST["Parameters"])) {
    var_dump($_POST["Parameters"]);
}
?>
