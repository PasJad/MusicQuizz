<?php
require_once("./models/parametres.php");
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
        if (isset($_POST["NomParametre"])) {
            require("./models/parametres.php");

            if ($mParam->add($_POST["NomParametre"])) {
                header("Location: " . "../views/games/game.php");
            }
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
