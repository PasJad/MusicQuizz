<?php



require_once("./models/Musiques.php");
require_once("./config/db.php");
require_once("./models/TypeMusiques.php");



$ctrlm = new ControllerMusic();
$mesTitres = $ctrlm->show();
$mesOptionsTypes = $ctrlm->showOptions();

if ($action == "delete") {
    if (empty($id)) {
        header("Location: index.php?uc=media&action=show");
    } else {
        $ctrlm->delete($id);
        header("Location: index.php?uc=media&action=show");
    }
}

if ($action == "cree") {
    $submit = filter_input(INPUT_POST, 'submitNew', FILTER_SANITIZE_STRING);
    if (isset($submit)) {

        $titre = filter_input(INPUT_POST, 'nomMusique', FILTER_SANITIZE_STRING);
        $desc = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $type = filter_input(INPUT_POST, 'optionsTypes', FILTER_SANITIZE_STRING);
        $mediasMusiques = $_FILES['uploadMusique'];
        $mediasImages = $_FILES['uploadImage'];
        if (!empty($titre) && !empty($desc) && !empty($mediasImages) && !empty($mediasMusiques) && !empty($type)) {
            $ctrlm->create($titre, $desc, $mediasMusiques, $mediasImages, $type);
            header("Location: index.php?uc=media&action=show");
        }
    }
}

if ($action == "edit") {

    $monTitre = $ctrlm->getTitreById($id);
    if (empty($monTitre)) {
        header("Location: index.php?uc=media&action=show");
        exit();
    }
    require_once("./views/games/mediaEdit.php");
}

if ($action == "nouveau") {
    require_once("./views/games/mediaCreate.php");
}

if ($action == "show") {
    require_once("./views/games/mediaPanel.php");
}

if ($action == "modifier") {
    $submit = filter_input(INPUT_POST, 'submitEdit', FILTER_SANITIZE_STRING);
    if (isset($submit)) {

        $titre = filter_input(INPUT_POST, 'nomMusique', FILTER_SANITIZE_STRING);
        $desc = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $type = filter_input(INPUT_POST, 'optionsTypes', FILTER_SANITIZE_STRING);
        $mediasMusiques = $_FILES['uploadMusique'];
        $mediasImages = $_FILES['uploadImage'];
        if (!empty($titre) && !empty($desc) && !empty($mediasImages) && !empty($mediasMusiques) && !empty($type) && !empty($id)) {
            $ctrlm->edit($titre, $desc, $mediasMusiques, $mediasImages, $type, $id,$monTitre);
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
    function delete($IdMusiqueADelete)
    {
        $musique = $this->getTitreById($IdMusiqueADelete);
        unlink($musique[0]['Musique']);
        unlink($musique[0]['ImagePochette']);
        $this->mMusic->deleteMusiqueById($IdMusiqueADelete);
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
        if ($fileImage['size'][0] > MAX_FILESIZE_AUDIO) {
            $sizeOk = false;
        }
        return $sizeOk;
    }
}
