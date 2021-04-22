<?php
require_once("./models/users.php");
require_once("./views/games/register.php");
if (isset($_SESSION["User"])) {
    header("Location: ./index.php?uc=accueil");
    exit();
}

$submit = filter_input(INPUT_POST, 'submitRegister', FILTER_SANITIZE_STRING);
$pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING);
$mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL);
$mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING);
$ctrlr = new ControllerRegister();

if ($action == "inscription") {
    if (isset($submit)) {
        if (!empty($pseudo) && !empty($mail) && !empty($mdp)) {
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                echo "<script>alert('Veuillez entrer un mail valide !')</script>";
            } else {
                $ctrlr->create($pseudo, $mail, $mdp, 0);
                header("Location: ./index.php?uc=Login");
                exit();
            }
        }
    }
}
class ControllerRegister
{

    protected $mUser;

    public function __construct()
    {
        $this->mUser = new Users();
    }

    public function show()
    {
        //TODO Montrer tout les utilisateurs


    }

    /**
     * Fonction de création de compte et redirection
     *
     * @param [type] $pPseudo
     * @param [type] $pMail
     * @param [type] $pMdp
     * @param [type] $pStatut
     * @return void
     */
    public function create($pPseudo, $pMail, $pMdp, $pStatut)
    {   // ? Peut-être que le Hashage n'est pas bien placé
        $hpswd = password_hash($pMdp, PASSWORD_DEFAULT);
        if ($this->mUser->add($pPseudo, $pMail, $hpswd, $pStatut)) {
        }
    }
    function edit()
    {
    }
    function delete()
    {
    }

    /**
     * Get the value of mUser
     */
    public function getMUser()
    {
        return $this->mUser;
    }

    /**
     * Set the value of mUser
     *
     * @return  self
     */
    public function setMUser($mUser)
    {
        $this->mUser = $mUser;

        return $this;
    }
}
