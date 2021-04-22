<?php
require_once("./models/Users.php");
$AdminBanner = "";
$userModify = array();
if (!isset($_SESSION["User"])) {
    header("Location: ./index.php?uc=Login");
    exit();
}
if ($_SESSION["User"][0]['Statut'] == 1) {
    $AdminBanner = "";
}
$ctrlp = new ControllerProfil();
$mesParties = array();
if ($action == "edit" && $_SESSION['User'][0]['IdUser'] == $id || $action == "edit" && $_SESSION['User'][0]['Statut'] == 1) {
    $userModify = $ctrlp->getUserById($id);
    
    require_once("./views/games/profilEdit.php");
}
if ($action == "") {
    $mesParties = $ctrlp->getQuizByUser($_SESSION['User']);
    if (empty($mesParties)) {
        $mesParties = array();
        $mesParties['0']['IdQuizz'] = "Faites une partie !";
        $mesParties['0']['Score'] = "Ø";
    }
    require_once("./views/games/profil.php");
}
if ($action == "showUsers") {
    $mesUsers = array();
    $mesUsers = $ctrlp->getAllUsers();
    require_once("./views/games/userPanel.php");
}

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
            //On modifie et on redirige vers le panel
            $monUser = $_SESSION['User'];
            if ($_SESSION['User'][0]['Email'] == $Email) {
                $_SESSION['User'] = $ctrlp->UpdateProfil($Nom, $Pseudo, $Email, $Mdp, $Avatar, $monUser);
                header("Location: index.php?uc=profil");
                exit();
            }
            else{
                $ctrlp->UpdateProfil($Nom, $Pseudo, $Email, $Mdp, $Avatar, $monUser);
                header("Location: index.php?uc=profil&action=showUsers");
                exit();
            }
            
            
        }
    }
}
//Si l'action est delete type (pour les types de musique)
if ($action == "delete") {
    //Vérification qu'on a bien choisi un id à supprimer si il n'y en a pas on renvoie au panel
    if (empty($id)) {
        header("Location: index.php?uc=profil&action=show");
    } else {
        //Sinon on supprime et redirige
        $ctrlp->delete($id);
        header("Location: index.php?uc=profil&action=show");
    }
}

if ($action == "nouveau") {
    require_once("./views/games/profilCreate.php");
}

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
            //Si ça n'est pas vide on créer
            $ctrlp->createUser($nom,$pseudo,$mail,$mdp,$statut,$mediasImages);
            header("Location: index.php?uc=profil&action=showUsers");
            exit();
        }
    }
}

class ControllerProfil
{
    private $mUser;

    function __construct()
    {
        $this->mUser = new Users();
    }
    public function getUserById($id)
    {
        return $this->mUser->getUserById($id);
    }
    public function createUser($nom, $pseudo, $mail, $pwd, $statut, $img)
    {
        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        $Errorflag = false;
        $filenameImage = $img['name'][0];
        $filenameImage = uniqid() . "." . pathinfo($filenameImage, PATHINFO_EXTENSION);
        $pathImage = "./user/img/" . $filenameImage;
        $pdo = Database::getPDO();
        $pdo->beginTransaction();

        if ($Errorflag == false) {
            if ($this->checkFilesType($img)) {
            } else {
                $Errorflag = true;
            }
            if ($this->checkFilesSize($img)) {
            } else {
                $Errorflag = true;
            }
            if ($this->mUser->addCompleteUser($nom,$pseudo,$mail,$pwd,$statut,$pathImage) && $Errorflag == false) {
                if (move_uploaded_file($img['tmp_name'][0], $pathImage)) {
                } else {
                    $Errorflag = true;
                }
            } else {
            }
        }
        if ($Errorflag == true) {
            $pdo->rollBack();
        } else {
            $pdo->commit();
        }
    }
    public function getAllUsers()
    {
        return $this->mUser->getAllUsers();
    }
    public function getQuizByUser($user)
    {
        return $this->mUser->getAllQuizFromUserId($user[0]['IdUser']);
    }
    public function delete($id)
    {
        $this->mUser->deleteUserById($id);
    }

    function UpdateProfil($nom, $pseudo, $mail, $pwd, $img, $monUser)
    {
        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        $Errorflag = false;
        $filenameImage = $img['name'][0];
        $filenameImage = uniqid() . "." . pathinfo($filenameImage, PATHINFO_EXTENSION);
        $pathImage = "./user/img/" . $filenameImage;
        $pdo = Database::getPDO();
        $pdo->beginTransaction();

        if ($Errorflag == false) {
            if ($img['name'][0] == "") {
                $img = $monUser[0]['Avatar'];
                if ($this->mUser->UpdateUser($monUser[0]['IdUser'], $nom, $pseudo, $mail, $pwd, $img)) {
                }
            } else {
                if ($this->checkFilesType($img)) {
                } else {
                    $Errorflag = true;
                }
                if ($this->checkFilesSize($img)) {
                } else {
                    $Errorflag = true;
                }
                if ($this->mUser->UpdateUser($monUser[0]['IdUser'], $nom, $pseudo, $mail, $pwd, $pathImage) && $Errorflag == false) {
                    if (move_uploaded_file($img['tmp_name'][0], $pathImage)) {
                        if (!empty($monUser[0]['Avatar'])) {
                            if ($monUser[0]['Avatar'] != "./user/img/default.jpg") {
                                unlink($monUser[0]['Avatar']);
                            }
                        }
                    } else {
                        $Errorflag = true;
                    }
                } else {
                }
            }
        }
        if ($Errorflag == true) {
            $pdo->rollBack();
        } else {
            $pdo->commit();
            return $this->mUser->getUserByMail($mail);
        }
    }
    function checkFilesType($fileImage)
    {
        // Process
        $typeOk = true;
        $fileTypeImage = mime_content_type($fileImage['tmp_name'][0]);
        if (strpos($fileTypeImage, 'image/') === false) {
            $typeOk = false;
        }
        // Output
        return $typeOk;
    }
    public function checkFilesSize($fileImage)
    {
        $sizeOk = true;
        if ($fileImage['size'][0] > MAX_FILESIZE_IMAGE) {
            $sizeOk = false;
        }
        return $sizeOk;
    }
}
