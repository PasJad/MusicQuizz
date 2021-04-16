<?php


require_once("./models/Musiques.php");
require_once("./config/db.php");

if ($action == "nouveau") {
    require_once("./views/games/mediaCreate.php");
}


$ctrlm = new ControllerMusic();
$mesTitres = $ctrlm->show();
var_dump($mesTitres);

if ($action == "cree") {
    $submit = filter_input(INPUT_POST, 'submitNew', FILTER_SANITIZE_STRING);
    if (isset($submit)) {

        $titre = filter_input(INPUT_POST, 'nomMusique', FILTER_SANITIZE_STRING);
        $desc = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $type = filter_input(INPUT_POST, 'typeMusique', FILTER_SANITIZE_STRING);
        $mediasMusiques = $_FILES['uploadMusique'];
        $mediasImages = $_FILES['uploadImage'];
        if (!empty($titre) && !empty($desc) && !empty($mediasImages) && !empty($mediasMusiques) && !empty($type)) {
            $ctrlm->create($titre, $desc, $mediasMusiques, $mediasImages, $type);
        }
    }
}

if ($action == "show") {
    require_once("./views/games/mediaPanel.php");
}

class ControllerMusic
{
    private $mMusic;

    function __construct()
    {
        $this->mMusic = new Musiques();
    }
    function show()
    {

        return $this->mMusic->getAllMusiques();
    }
    function create($titre, $desc, $mediasMusiques, $mediasImages, $type)
    {
        $filenameMusique = $mediasMusiques['name'][0];
        $filenameImage = $mediasImages['name'][0];
        var_dump($filenameMusique);
        $pathMusique = "./medias/music/" . $filenameMusique;
        $pathImage = "./medias/img/" . $filenameImage;
        $pdo = Database::getPDO();
        $pdo->beginTransaction();
        try {
            if ($this->mMusic->add($titre, $desc, $pathMusique, $pathImage, $type)) {
                try {
                    move_uploaded_file($mediasMusiques['tmp_name'][0], $pathMusique);
                    move_uploaded_file($mediasImages['tmp_name'][0], array());
                } catch (Exception $th) {
                    $pdo->rollBack();
                    header("Location: index.php?uc=media&action=show");
                    throw $th;
                }
                $pdo->commit();
                header("Location: index.php?uc=media&action=show");
            } else {
                $pdo->rollBack();
            }
        } catch (Exception $th) {
            $pdo->rollBack();
            throw $th;
        }
    }
    function edit()
    {
    }
    function delete()
    {
    }
}
