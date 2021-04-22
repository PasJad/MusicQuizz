<?php
//On vérifie si on est administrateur sinon on nous renvoie à l'accueil
if ($_SESSION['User'][0]['Statut'] != 1) {
    header("Location: index.php?uc=accueil");
    exit();
}
//Modèle nécessaire et base de données
require_once("./models/Musiques.php");
require_once("./config/db.php");
require_once("./models/TypeMusiques.php");


//Initialisation du controlleur
$ctrlm = new ControllerMusic();
//Initialisation de mes variable liés à ma vue
$mesTitres = $ctrlm->show();
$mesTypes = $ctrlm->showOptions();
$mesOptionsTypes = $ctrlm->showOptions();

//Si l'acion est show type on a le panel des types de musique
if ($action == "showType") {
    require_once("./views/games/mediaTypePanel.php");
}

//Si l'action est delete (par défaut les musiques)
if ($action == "delete") {
    //Vérification qu'on a bien choisi un id à supprimer si il n'y en a pas on renvoie au panel
    if (empty($id)) {
        header("Location: index.php?uc=media&action=show");
    } else {
        //Sinon on supprime et redirige
        $ctrlm->delete($id);
        header("Location: index.php?uc=media&action=show");
    }
}

//Si l'action est delete type (pour les types de musique)
if ($action == "deleteType") {
    //Vérification qu'on a bien choisi un id à supprimer si il n'y en a pas on renvoie au panel
    if (empty($id)) {
        header("Location: index.php?uc=media&action=show");
    } else {
        //Sinon on supprime et redirige
        $ctrlm->deleteType($id);
        header("Location: index.php?uc=media&action=show");
    }
}
//Si l'action est cree (par défaut les musique)
if ($action == "cree") {
    //On vérifie qu'on a bien été envoyé depuis le form
    $submit = filter_input(INPUT_POST, 'submitNew', FILTER_SANITIZE_STRING);
    if (isset($submit)) {
        //Filtrages des données reçu
        $titre = filter_input(INPUT_POST, 'nomMusique', FILTER_SANITIZE_STRING);
        $desc = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $type = filter_input(INPUT_POST, 'optionsTypes', FILTER_SANITIZE_STRING);
        $mediasMusiques = $_FILES['uploadMusique'];
        $mediasImages = $_FILES['uploadImage'];
        //On vérifie que ça n'est pas vide
        if (!empty($titre) && !empty($desc) && !empty($mediasImages) && !empty($mediasMusiques) && !empty($type)) {
            //Si ça n'est pas vide on créer
            $ctrlm->create($titre, $desc, $mediasMusiques, $mediasImages, $type);
            header("Location: index.php?uc=media&action=show");
            exit();
        }
    }
}
//Si l'action est creeType (pour les types de musique)
if ($action == "creeType") {
    //On vérifie si on est envoyé depuis le form
    $submit = filter_input(INPUT_POST, 'submitNew', FILTER_SANITIZE_STRING);
    if (isset($submit)) {
        //Filtrage des données reçu
        $nomType = filter_input(INPUT_POST, 'nomType', FILTER_SANITIZE_STRING);
        //Si les données sont pas vide
        if (!empty($nomType)) {
            //On créer un nouveau type
            $ctrlm->createType($nomType);
            header("Location: index.php?uc=media&action=showType");
            exit();
        }
    }
}

//Si action est edit
if ($action == "edit") {
    //On récupère l'id du type  à modifier
    $monTitre = $ctrlm->getTitreById($id);
    //Vérification si c'est vide
    if (empty($monTitre)) {
        //Si vide on renvoie au panel de base
        header("Location: index.php?uc=media&action=show");
        exit();
    }
    //Si on a pas été redirigé on vas a la page d'edit 
    require_once("./views/games/mediaEdit.php");
}

//Si action est edit
if ($action == "editType") {
    //Vérification si c'est vide
    if (empty($id)) {
        //Si vide on renvoie au panel de base
        header("Location: index.php?uc=media&action=showType");
        exit();
    }
    //Si on a pas été redirigé on vas a la page d'edit 
    require_once("./views/games/mediaTypeEdit.php");
}


//Si action nouveau on envoie a la page de création pour les chansons
if ($action == "nouveau") {
    require_once("./views/games/mediaCreate.php");
}
//Si action nouveauType on envoie a la page de création pour les types
if ($action == "nouveauType") {
    require_once("./views/games/mediaTypeCreate.php");
}
//Si action show on montre le panel
if ($action == "show") {
    require_once("./views/games/mediaPanel.php");
}

//Si action modifier cela veut dire qu'on revient de la page d'edit
if ($action == "modifier") {
    //On vérifie si on a été envoyé depuis le form d'édition
    $submit = filter_input(INPUT_POST, 'submitEdit', FILTER_SANITIZE_STRING);
    if (isset($submit)) {
        //Filtrage des données
        $titre = filter_input(INPUT_POST, 'nomMusique', FILTER_SANITIZE_STRING);
        $desc = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $type = filter_input(INPUT_POST, 'optionsTypes', FILTER_SANITIZE_STRING);
        $mediasMusiques = $_FILES['uploadMusique'];
        $mediasImages = $_FILES['uploadImage'];
        //Vérification si c'est pas vide
        if (!empty($titre) && !empty($desc) && !empty($mediasImages) && !empty($mediasMusiques) && !empty($type) && !empty($id)) {
            //On modifie et on redirige vers le panel
            $ctrlm->edit($titre, $desc, $mediasMusiques, $mediasImages, $type, $id,$monTitre);
            header("Location: index.php?uc=media&action=show");
        }
    }
}

//Si action modifier cela veut dire qu'on revient de la page d'edit de type
if ($action == "modifierType") {
    //On vérifie si on a été envoyé depuis le form d'édition
    $submit = filter_input(INPUT_POST, 'submitEdit', FILTER_SANITIZE_STRING);
    if (isset($submit)) {
        //Filtrage des données
        $type = filter_input(INPUT_POST, 'nomType', FILTER_SANITIZE_STRING);
        $typeId = $id;
        //Vérification si c'est pas vide
        if (!empty($type)) {
            //On modifie et on redirige vers le panel
            $ctrlm->editType($type,$typeId);
            header("Location: index.php?uc=media&action=show");
        }
    }
}



class ControllerMusic
{
    private $mMusic;
    private $mType;

    function __construct()
    {
        $this->mMusic = new Musiques();
        $this->mType = new Types();
    }
    function show()
    {
        return $this->mMusic->getAllMusiques();
    }
    function showOptions()
    {
        return $this->mType->getAllOptions();
    }
    public function getTitreById($monIdMusique)
    {
        return $this->mMusic->getMusiqueById($monIdMusique);
    }

    public function createType($type)
    {
        if ($this->mType->add($type)) {

        }
        else{
            
        }
    }
    function create($titre, $desc, $mediasMusiques, $mediasImages, $type)
    {
        $Errorflag = false;
        $filenameMusique = $mediasMusiques['name'][0];
        $filenameImage = $mediasImages['name'][0];
        var_dump($filenameMusique);
        $pathMusique = "./medias/music/" . $filenameMusique;
        $pathImage = "./medias/img/" . $filenameImage;
        $pdo = Database::getPDO();
        $pdo->beginTransaction();

        if ($this->checkFilesType($mediasMusiques, $mediasImages)) {
        } else {
            $Errorflag = true;
        }
        if ($this->checkFilesSize($mediasMusiques, $mediasImages)) {
        } else {
            $Errorflag = true;
        }
        if ($Errorflag == false) {
            if ($this->mMusic->add($titre, $desc, $pathMusique, $pathImage, $type)) {
                if (move_uploaded_file($mediasMusiques['tmp_name'][0], $pathMusique) &&  move_uploaded_file($mediasImages['tmp_name'][0], $pathImage)) {
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
    function edit($titre, $desc, $mediasMusiques, $mediasImages, $type, $idEditMusique,$monTitre)
    {

        $Errorflag = false;
        $filenameMusique = $mediasMusiques['name'][0];
        $filenameImage = $mediasImages['name'][0];
        $pathMusique = "./medias/music/" . $filenameMusique;
        $pathImage = "./medias/img/" . $filenameImage;
        $pdo = Database::getPDO();
        $pdo->beginTransaction();
        if ($this->checkFilesType($mediasMusiques, $mediasImages)) {
        } else {
            $Errorflag = true;
        }
        if ($this->checkFilesSize($mediasMusiques, $mediasImages)) {

        } else {
            $Errorflag = true;
        }
        if ($this->mMusic->UpdateMusique($titre, $desc, $pathMusique, $pathImage, $type, $idEditMusique)) {
            if (move_uploaded_file($mediasMusiques['tmp_name'][0], $pathMusique) &&  move_uploaded_file($mediasImages['tmp_name'][0], $pathImage)) {
                    unlink($monTitre[0]['Musique']);
                    unlink($monTitre[0]['ImagePochette']);
            } else {
                $Errorflag = true;
            }
        } else {
            
        }
        if ($Errorflag == true) {
            $pdo->rollBack();
        } else {
            $pdo->commit();
        }
    }
    public function editType($nameType,$idTypeToEdit)
    {
        $this->mType->UpdateTypeById($idTypeToEdit,$nameType);
    }
    function delete($IdMusiqueADelete)
    {
        $musique = $this->getTitreById($IdMusiqueADelete);
        unlink($musique[0]['Musique']);
        unlink($musique[0]['ImagePochette']);
        $this->mMusic->deleteMusiqueById($IdMusiqueADelete);
    }
    public function deleteType($IdTypeADelete)
    {
        $this->mType->deleteTypeById($IdTypeADelete);
    }

    function checkFilesType($fileMusic, $fileImage)
    {
        // Process
        $typeOk = true;
        $fileTypeMusic = mime_content_type($fileMusic['tmp_name'][0]);
        $fileTypeImage = mime_content_type($fileImage['tmp_name'][0]);
        if (strpos($fileTypeMusic, 'audio/') === false) {
            $typeOk = false;
        }
        if (strpos($fileTypeImage, 'image/') === false) {
            $typeOk = false;
        }
        // Output
        return $typeOk;
    }
    public function checkFilesSize($fileMusic, $fileImage)
    {
        $sizeOk = true;
        if ($fileMusic['size'][0] > MAX_FILESIZE_AUDIO) {
            $sizeOk = false;
        }
        if ($fileImage['size'][0] > MAX_FILESIZE_IMAGE) {
            $sizeOk = false;
        }
        return $sizeOk;
    }
}
