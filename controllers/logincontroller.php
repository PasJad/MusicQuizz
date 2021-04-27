<?php
/**
  * Nom : Tayan
  * Prénom : Jad
  * Ecole : CFPT-Informatique
  * Date : 23.04.2021
  * Projet : TPI 2021
  * Fichier : logincontroller.php
  */
//Initialisation
//Modèles nécessaire au controlleurs
require_once("./models/Users.php");
//Affiche ma vue
require_once("./views/games/login.php");


//Initialisation de mon controlleur
$ctrll = new ControllerLogin();

//Si l'action est connexion
if ($action == "connexion") {
    //On vérifie qu'on à été envoyé du formulaire
    $submit = filter_input(INPUT_POST, 'submitLogin', FILTER_SANITIZE_STRING);
    if (isset($submit)) {
        //Vérification et filtrage de nos données
        $mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL);
        $mail = strtolower($mail);
        $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING);
        if (!empty($mail) && !empty($mdp)) {
            $ctrll->Connexion($mail, $mdp);
        }
    }
}
//Si l'action est deconnexion on se déconnecte dans tout les cas
if ($action == "deconnexion") {
    $ctrll->deconnexion();
}

//Si on est déjà connecté
if (isset($_SESSION["User"])) {
    //On redirige directement à l'accueil
    header("Location: ./index.php?uc=accueil");
    exit();
}

class ControllerLogin
{
    //Champs
    protected $mUser;

    /**
     * Constructeur par défaut
     */
    public function __construct()
    {
        $this->mUser = new Users();
    }

    /**
     * Fonction de création de compte et redirection
     *
     * @param [string] $pPseudo
     * @param [string] $pMail
     * @param [string] $pMdp
     * @param [string] $pStatut
     * @return void
     */
    public function connexion($mail, $mdp)
    {
        //Récupère le mot de passe hashé dans la base de données
        $hashedpwd = $this->mUser->getUserPswdByMail($mail);
        if (empty($hashedpwd)) {
            //Si c'est vide on affiche une alerte
            echo '<script>alert("Compte Inexistant")</script>';
        } else {
            //Vérifie que le mot de passe entré et celui associé au mail dans la base soit le même
            if (password_verify($mdp, $hashedpwd['Mdp'])) {
                //Créer une session User
                $_SESSION["User"] = $this->mUser->getUserByMail($mail);
            } else {
                //Si le mot de passe n'est pas bon on envoie une alerte
                echo '<script>alert("Information erroné")</script>';
            }
        }
    }

    /**
     * Fonction controlleur qui s'occupe de nous déconnecter
     *
     * @return void
     */
    public function deconnexion()
    {
        //Invalide la session et la détruit
        session_unset();
        session_destroy();
    }
}
