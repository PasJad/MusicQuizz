<?php
require_once("./models/Users.php");
require_once("./views/games/Login.php");
$submit = filter_input(INPUT_POST, 'submitLogin', FILTER_SANITIZE_STRING);
$mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL);
$mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING);

$ctrll = new ControllerLogin();

if ($action == "connexion") {
    if (!empty($mail) && !empty($mdp)) {
        $ctrll->Connexion($mail, $mdp);
    }
}
if ($action == "deconnexion") {
    $ctrll->Deconnexion();
}


if (isset($_SESSION["User"])) {
    var_dump($_SESSION["User"]);
    header("Location: ./index.php?uc=accueil");
    exit();
} else {
}

class ControllerLogin
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
    public function Connexion($pMail, $pMdp)
    {
        //Récupère le mot de passe hashé dans la base de données
        $hashedpwd = $this->mUser->getUserPswdByMail($pMail);
        if (empty($hashedpwd)) {
            echo '<script>alert("Compte Inexistant")</script>';
        } else {
            //Vérifie que le mot de passe entré et celui associé au mail dans la base soit le même
            if (password_verify($pMdp, $hashedpwd['Mdp'])) {
                //Créer une session User
                $_SESSION["User"] = $this->mUser->getUserByMail($pMail);
            } else {
                echo '<script>alert("Information erroné")</script>';
            }
        }
    }
    public function Deconnexion()
    {
        session_unset();
        session_destroy();
    }

    function edit()
    {
        return $this;
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
