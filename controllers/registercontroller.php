<?php
/**
  * Nom : Tayan
  * Prénom : Jad
  * Ecole : CFPT-Informatique
  * Date : 23.04.2021
  * Projet : TPI 2021
  * Fichier : registercontroller.php
  */
//Modèles nécessaire au controlleurs
require_once("./models/users.php");
require_once("./views/games/register.php");

//Initialisation de mon controleur
$ctrlr = new ControllerRegister();

//On vérifie qu'on est pas déjà connecté si c'est le cas on est directement envoyé à l'accueil
if (isset($_SESSION["User"])) {
    header("Location: ./index.php?uc=accueil");
    exit();
}

//Si l'action est inscription
if ($action == "inscription") {
    //On vérifie qu'on à bien été envoyé du formulaire
    $submit = filter_input(INPUT_POST, 'submitRegister', FILTER_SANITIZE_STRING);
    if (isset($submit)) {
        //Vérification et filtrage des données reçus 
        $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING);
        $mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL);
        $mail = strtolower($mail);
        $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING);
        if (!empty($pseudo) && !empty($mail) && !empty($mdp)) {
            //On vérifie que l'email est correct
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                //Si l'email n'est pas valide on envoie une alerte
                echo "<script>alert('Veuillez entrer un mail valide !')</script>";
            } else {
                //Si tout est bon on créer notre compte
                $ctrlr->create($pseudo, $mail, $mdp, 0);
                header("Location: ./index.php?uc=login");
                exit();
            }
        }
    }
}
class ControllerRegister
{
    //Champs
    protected $mUser;

    /**
     * Constructeurs par défaut
     */
    public function __construct()
    {
        $this->mUser = new Users();
    }

    /**
     * Fonction controlleur qui s'occupe de gérer la création du compte
     *
     * @param [string] $pPseudo
     * @param [string] $pMail
     * @param [string] $pMdp
     * @param [int] $pStatut
     * @return void
     */
    public function create($pPseudo, $pMail, $pMdp, $pStatut)
    {   
        //Traitement
        $hpswd = password_hash($pMdp, PASSWORD_DEFAULT);
        if ($this->mUser->add($pPseudo, $pMail, $hpswd, $pStatut)) {
        }
    }
}
