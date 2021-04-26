<?php

/**
 * Nom : Tayan
 * Prénom : Jad
 * Ecole : CFPT-Informatique
 * Date : 23.04.2021
 * Projet : TPI 2021
 * Fichier : profilcontroller.php
 */
//Modèles nécessaire au controlleurs
require_once("./models/Users.php");
//Initialisation
$AdminBanner = "";
$scoreTotal = 0;
$userModify = array();
$ctrlp = new ControllerProfil();
$mesParties = array();

//Si nous essayons d'accéder à la page sans se connecter on est renvoyé à la page de connexion
if (!isset($_SESSION["User"])) {
    header("Location: ./index.php?uc=login");
    exit();
}
//Si notre compte est administrateur on lui montre les différents panel de CRUD
if ($_SESSION["User"][0]['Statut'] == 1) {
    $AdminBanner = "<nav class='navBar'>
    <a href='index.php?uc=media&action=show' class='navBtn'>Chansons</a>
    <a href='index.php?uc=media&action=showType' class='navBtn'>Type Chansons</a>
    <a href='index.php?uc=profil&action=showUsers' class='navBtn'>Utilisateurs</a>
    </nav>";
}
//On vérifie si on à le droit d'accéder à tel page de modification de profil. Il faut que ça soit notre compte ou sinon l'admin à le droit partout.
if ($action == "edit" && $_SESSION['User'][0]['IdUser'] == $id || $action == "edit" && $_SESSION['User'][0]['Statut'] == 1) {
    $userModify = $ctrlp->getUserById($id);
    require_once("./views/games/profilEdit.php");
}
//Si il n'y a pas d'action c'est qu'on est sur notre page de profil
if ($action == "") {
    //Récupération des parties
    $mesParties = $ctrlp->getQuizByUser($_SESSION['User']);
    //Si nous n'avons pas de partie je créer une fausse partie qui explique qu'il faut en jouer au moins une.
    if (empty($mesParties)) {
        $mesParties = array();
        $mesParties['0']['IdQuizz'] = "Faites une partie !";
        $mesParties['0']['Score'] = "Ø";
    } else {
        //Pour toutes mes parties j'additionne leur score pour avoir mon total
        foreach ($mesParties as $key => $value) {
            $scoreTotal += $value['Score'];
        }
    }
    //J'affiche mon profil
    require_once("./views/games/profil.php");
}
//Si on est admin on peux accéder à la page du panel utilisateurs
if ($action == "showUsers" && $_SESSION['User'][0]['Statut'] == 1) {
    $mesUsers = array();
    //On récupère tout nos utilisateurs et ensuite on affiche la page
    $mesUsers = $ctrlp->getAllUsers();
    require_once("./views/games/userPanel.php");
}
//Si on essaie d'accéder au panel sans être admin on est redirigé
if ($action == "showUsers" && $_SESSION['User'][0]['Statut'] == 0) {
    require_once("./views/games/profil.php");
}


//Lorsqu'on veut modifier
if ($action == "modifier") {
    //On vérifie si on a été envoyé depuis le form d'édition
    $submit = filter_input(INPUT_POST, 'submitEdit', FILTER_SANITIZE_STRING);
    if (isset($submit)) {
        //Filtrage des données
        $Nom = filter_input(INPUT_POST, 'nomUser', FILTER_SANITIZE_STRING);
        $Pseudo = filter_input(INPUT_POST, 'pseudoUser', FILTER_SANITIZE_STRING);
        $Email = filter_input(INPUT_POST, 'mailUser', FILTER_SANITIZE_STRING);
        $Mdp = filter_input(INPUT_POST, 'mdpUser', FILTER_SANITIZE_STRING);
        $Avatar = $_FILES['uploadImage'];
        //Vérification si c'est pas vide
        if (!empty($Nom) && !empty($Pseudo) && !empty($Email) && !empty($Mdp) && !empty($id)) {
            //On vérifie si l'email est valide
            if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
                //Si l'email n'est pas valide on envoie une alerte
                echo "<script>alert('Veuillez entrer un mail valide !')</script>";
                header("Location: index.php&action=login");
                exit();
            } else {
                //On modifie
                $monUser = $_SESSION['User'];
                //Si c'est notre compte qu'on est entrain de modifier on est renvoyé à notre page de profil
                if ($_SESSION['User'][0]['IdUser'] == $id) {
                    $_SESSION['User'] = $ctrlp->UpdateProfil($Nom, $Pseudo, $Email, $Mdp, $Avatar, $monUser);
                    header("Location: index.php?uc=profil");
                    exit();
                } else if ($_SESSION['User'][0]['Statut'] == 1) {
                    //Dans le cas ou ce n'est pas le cas c'est uniquement l'admin qui à ses droits et on est redirigé vers le panel
                    $monUser = $ctrlp->getUserById($id);
                    $ctrlp->UpdateProfil($Nom, $Pseudo, $Email, $Mdp, $Avatar, $monUser);
                    header("Location: index.php?uc=profil&action=showUsers");
                    exit();
                }
            }
        } else {
            echo "<script>alert('Veuillez remplir tout les champs obligatoire')</script>";
        }
    }
}
//Si l'action est delete
if ($action == "delete" && $_SESSION['User'][0]['IdUser'] == $id || $action == "delete" && $_SESSION['User'][0]['Statut'] == 1) {
    //Vérification qu'on a bien choisi un id à supprimer si il n'y en a pas on renvoie au panel
    if (empty($id)) {
        header("Location: index.php?uc=profil&action=showUsers");
    } else {
        //Sinon on supprime et redirige
        $ctrlp->delete($id);
        header("Location: index.php?uc=profil&action=showUsers");
    }
}


//Redirige à la page de création
if ($action == "nouveau") {
    require_once("./views/games/profilCreate.php");
}
//Si on tente de créer un compte
if ($action == "cree") {
    //On vérifie qu'on a bien été envoyé depuis le form
    $submit = filter_input(INPUT_POST, 'submitNew', FILTER_SANITIZE_STRING);
    if (isset($submit)) {
        //Filtrages des données reçu
        $nom = filter_input(INPUT_POST, 'nomUser', FILTER_SANITIZE_STRING);
        $pseudo = filter_input(INPUT_POST, 'pseudoUser', FILTER_SANITIZE_STRING);
        $mail = filter_input(INPUT_POST, 'mailUser', FILTER_SANITIZE_EMAIL);
        $mdp = filter_input(INPUT_POST, 'mdpUser', FILTER_SANITIZE_EMAIL);
        $statut = filter_input(INPUT_POST, 'statutUser', FILTER_SANITIZE_NUMBER_INT);
        $mediasImages = $_FILES['uploadImage'];
        //On vérifie que ça n'est pas vide
        if (!empty($nom) && !empty($pseudo) && !empty($mail) && !empty($mdp) && !empty($statut) && !empty($mediasImages)) {
            //Si ça n'est pas vide on créer et on redirige au panel
            $ctrlp->createUser($nom, $pseudo, $mail, $mdp, $statut, $mediasImages);
            header("Location: index.php?uc=profil&action=showUsers");
            exit();
        } else {
            echo "<script>alert('Veuillez remplir tout les champs obligatoire')</script>";
        }
    }
}


class ControllerProfil
{
    private $mUser;
    /**
     * Constructeurs par défaut
     */
    function __construct()
    {
        $this->mUser = new Users();
    }
    /**
     * Fonction controlleur qui renvoie un user pour un id donnée
     *
     * @param [type] $id
     * @return array
     */
    public function getUserById($id)
    {
        return $this->mUser->getUserById($id);
    }
    /**
     * Fonction controlleur qui s'occupe de la création de mon utilisateurs
     *
     * @param [string] $nom
     * @param [string] $pseudo
     * @param [string] $mail
     * @param [string] $pwd
     * @param [int] $statut
     * @param [img] $img
     * @return void
     */
    public function createUser($nom, $pseudo, $mail, $pwd, $statut, $img)
    {
        //Initialisation
        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        $Errorflag = false;
        $filenameImage = $img['name'][0];
        $filenameImage = uniqid() . "." . pathinfo($filenameImage, PATHINFO_EXTENSION);
        $pathImage = "./user/img/" . $filenameImage;
        $pdo = Database::getPDO();
        //Traitement
        $pdo->beginTransaction();
        //On vérifie les erreurs à toutes les étapes
        if ($Errorflag == false) {
            //Vérification du type envoyer
            if ($this->checkFilesType($img)) {
            } else {
                $Errorflag = true;
            }
            //Vérification de la taille du fichier
            if ($this->checkFilesSize($img)) {
            } else {
                $Errorflag = true;
            }
            //Si tout est bon on doit créer un utilisateurs au complet (Donc Nom en plus) et on vérifie si il n'y a pas de problème
            if ($this->mUser->addCompleteUser($nom, $pseudo, $mail, $pwd, $statut, $pathImage) && $Errorflag == false) {
                //On upload notre image 
                if (move_uploaded_file($img['tmp_name'][0], $pathImage)) {
                } else {
                    $Errorflag = true;
                }
            }
        }
        //Dans le cas ou le flag d'erreur à été déclenché on rollback pour annuler notre requete sql
        if ($Errorflag == true) {
            $pdo->rollBack();
        } else {
            //Sinon on commit notre requête
            $pdo->commit();
        }
    }

    /**
     * Fonction controlleur qui récupère tout les utilisateurs
     *
     * @return array
     */
    public function getAllUsers()
    {
        return $this->mUser->getAllUsers();
    }

    /**
     * Fonction controlleur qui récupère les quiz pour un user donnée
     *
     * @param [array] $user
     * @return array
     */
    public function getQuizByUser($user)
    {
        return $this->mUser->getAllQuizFromUserId($user[0]['IdUser']);
    }
    /**
     * Fonction controlleur qui pour un id donnée supprime un user
     *
     * @param [int] $id
     * @return void
     */
    public function delete($id)
    {
        $this->mUser->deleteUserById($id);
    }

    /**
     * Fonction controlleur qui s'occupe de modifier un user
     *
     * @param [string] $nom
     * @param [string] $pseudo
     * @param [string] $mail
     * @param [string] $pwd
     * @param [img] $img
     * @param [array] $monUser
     * @return void
     */
    function UpdateProfil($nom, $pseudo, $mail, $pwd, $img, $monUser)
    {
        //Initialisation
        $Errorflag = false;
        $filenameImage = $img['name'][0];
        $filenameImage = uniqid() . "." . pathinfo($filenameImage, PATHINFO_EXTENSION);
        $pathImage = "./user/img/" . $filenameImage;
        $pdo = Database::getPDO();
        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        //Traitement
        $pdo->beginTransaction();
        //Vérification des erreurs à chaque étapes
        if ($Errorflag == false) {
            //Si on a pas d'image
            if ($img['name'][0] == "") {
                //On garde l'avatar de base
                $img = $monUser[0]['Avatar'];
                //On update l'utilisateur
                $this->mUser->UpdateUser($monUser[0]['IdUser'], $nom, $pseudo, $mail, $pwd, $img);
            } else {
                //Alors on a une image
                //on vérifie le type de l'image 
                if ($this->checkFilesType($img)) {
                } else {
                    $Errorflag = true;
                }
                //On vérifie la taille de l'image
                if ($this->checkFilesSize($img)) {
                } else {
                    $Errorflag = true;
                }
                //On update et on vérifie si il n'y a toujours pas d'erreur
                if ($this->mUser->UpdateUser($monUser[0]['IdUser'], $nom, $pseudo, $mail, $pwd, $pathImage) && $Errorflag == false) {
                    //On upload notre fichier
                    if (move_uploaded_file($img['tmp_name'][0], $pathImage)) {
                        //Si l'avatar n'est pas vide
                        if (!empty($monUser[0]['Avatar'])) {
                            //Et que ce n'est pas l'image par défaut
                            if ($monUser[0]['Avatar'] != "./user/img/default.jpg") {
                                //Alors on supprime l'ancienne image de nos fichiers (le default est gardé car il est partagé entre mes users)
                                unlink($monUser[0]['Avatar']);
                            }
                        }
                    } else {
                        $Errorflag = true;
                    }
                }
            }
        }
        //Si le flag d'erreur à été levé
        if ($Errorflag == true) {
            //On annule notre requête
            $pdo->rollBack();
        } else {
            //Sinon on commit notre requete et on récupere notre User
            $pdo->commit();
            return $this->mUser->getUserByMail($mail);
        }
    }
    /**
     * Fonction controlleur qui s'occupe de vérifié le type reçu
     *
     * @param [img] $fileImage
     * @return bool
     */
    function checkFilesType($fileImage)
    {
        //Traitement
        $typeOk = true;
        //On récupère notre type d'image
        $fileTypeImage = mime_content_type($fileImage['tmp_name'][0]);
        //On vérifie si notre type est une image
        if (strpos($fileTypeImage, 'image/') === false) {
            $typeOk = false;
        }
        //Sortie
        return $typeOk;
    }
    /**
     * Fonction controlleur qui s'occupe de vérifie si la taille du fichier n'est pas trop grand
     *
     * @param [img] $fileImage
     * @return bool
     */
    public function checkFilesSize($fileImage)
    {
        //Traitement
        $sizeOk = true;
        //On vérifie qu'on ne dépasse pas la taille max d'une image (variable environnement pour la taille max)
        if ($fileImage['size'][0] > MAX_FILESIZE_IMAGE) {
            $sizeOk = false;
        }
        //Sortie
        return $sizeOk;
    }
}
