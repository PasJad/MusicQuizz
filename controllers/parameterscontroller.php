<?php
require_once("./models/parametres.php");

if (!isset($_SESSION["User"])) {
    header("Location: ./index.php?uc=login");
    exit();
} else {
    require_once("./views/games/accueil.php");
}



class ControllerParameters
{

    private $mParam;

    public function __construct()
    {
        $this->mParam = new Parametres();
    }

    public function show()
    {
        $_POST["Parameters"] = $this->mParam->getAllParameters();
    }
    public function create()
    {
        if ($this->mParam->add($_POST["NomParametre"])) {
        }
    }
    function edit()
    {
    }
    function delete()
    {
    }

    /**
     * Get the value of mParam
     */
    public function getMParam()
    {
        return $this->mParam;
    }
}
