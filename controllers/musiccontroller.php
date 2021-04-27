<?php

/**
 * Nom : Tayan
 * Prénom : Jad
 * Ecole : CFPT-Informatique
 * Date : 27.04.2021
 * Projet : TPI 2021
 * Fichier : musiccontroller.php
 */
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
            //On créer un nouveau type et on redirige
            $ctrlm->createType($nomType);
            header("Location: index.php?uc=media&action=showType");
            exit();
        }
    }
}

//Si action est edit
if ($action == "edit") {
    //On récupère l'id du type à modifier
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
        $monTitre = $ctrlm->getTitreById($id);
        //Vérification si c'est pas vide
        if (!empty($titre) && !empty($desc) && !empty($mediasImages) && !empty($mediasMusiques) && !empty($type) && !empty($id)) {
            //On modifie et on redirige vers le panel
            $ctrlm->edit($titre, $desc, $mediasMusiques, $mediasImages, $type, $id, $monTitre);
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
            $ctrlm->editType($type, $typeId);
            header("Location: index.php?uc=media&action=show");
        }
    }
}



class ControllerMusic
{
    //Champs
    private $mMusic;
    private $mType;

    /**
     * Constructeur par défaut
     */
    function __construct()
    {
        $this->mMusic = new Musiques();
        $this->mType = new Types();
    }
    /**
     * Fonction controlleur qui récupère toutes les musiques
     *
     * @return array
     */
    function show()
    {
        return $this->mMusic->getAllMusiques();
    }
    /**
     * Fonction controlleur qui s'occupe de récupérer toutes les options de types
     *
     * @return void
     */
    function showOptions()
    {
        return $this->mType->getAllOptions();
    }

    /**
     * Fonction controlleur qui s'occupe de récupérer une musique pour un id donnée
     *
     * @param [int] $monIdMusique
     * @return array
     */
    public function getTitreById($monIdMusique)
    {
        return $this->mMusic->getMusiqueById($monIdMusique);
    }

    /**
     * Fonction controlleur qui s'occupe de créer un type
     *
     * @param [string] $type
     * @return void
     */
    public function createType($type)
    {
        $this->mType->add($type);
    }
    /**
     * Fonction controlleur qui s'occupe de créer une musique
     *
     * @param [string] $titre
     * @param [string] $desc
     * @param [img] $mediasMusiques
     * @param [img] $mediasImages
     * @param [string] $type
     * @return void
     */
    function create($titre, $desc, $mediasMusiques, $mediasImages, $type)
    {
        //Initialisation
        $errorFlag = false;
        $filenameMusique = $mediasMusiques['name'][0];
        $filenameImage = $mediasImages['name'][0];
        $pathMusique = "./medias/music/" . $filenameMusique;
        $pathImage = "./medias/img/" . $filenameImage;
        $pdo = Database::getPDO();
        //Traitement
        $pdo->beginTransaction();
        //Vérification du type des fichiers envoyés
        if ($this->checkFilesType($mediasMusiques, $mediasImages) == false) {
            $errorFlag = true;
        } 
        //Vérification de la taille des fichiers envoyés
        if ($this->checkFilesSize($mediasMusiques, $mediasImages) == false) {
            $errorFlag = true;
        }
        //Vérification des erreurs à chaque étapes
        if ($errorFlag == false) {
            //Ajout et vérification des erreurs
            if ($this->mMusic->add($titre, $desc, $pathMusique, $pathImage, $type) && $errorFlag == false) {
                //Si il n'y a pas d'erreurs on upload nos fichiers
                if (move_uploaded_file($mediasMusiques['tmp_name'][0], $pathMusique) &&  move_uploaded_file($mediasImages['tmp_name'][0], $pathImage)) {
                } else {
                    $errorFlag = true;
                }
            }
        }
        //Si il y a une erreur on rollback notre requête
        if ($errorFlag == true) {
            $pdo->rollBack();
        } else {
            //Sinon on commit
            $pdo->commit();
        }
    }
    /**
     * Fonction controlleur qui s'occupe de modifier une chanson
     *
     * @param [string] $titre
     * @param [string] $desc
     * @param [audio] $mediasMusiques
     * @param [img] $mediasImages
     * @param [string] $type
     * @param [int] $idEditMusique
     * @param array $monTitre
     * @return void
     */
    function edit($titre, $desc, $mediasMusiques, $mediasImages, $type, $idEditMusique, $monTitre)
    {
        //Initialisation
        $errorFlag = false;
        $filenameMusique = $mediasMusiques['name'][0];
        $filenameImage = $mediasImages['name'][0];
        $pathMusique = "./medias/music/" . $filenameMusique;
        $pathImage = "./medias/img/" . $filenameImage;
        $pdo = Database::getPDO();
        //Traitement
        $pdo->beginTransaction();
        //Vérification des types de nos fichiers
        if ($this->checkFilesType($mediasMusiques, $mediasImages) == false) {
            $errorFlag = true;
        } 
        //Vérification de la taille de nos fichiers
        if ($this->checkFilesSize($mediasMusiques, $mediasImages) == false) {
            $errorFlag = true;
        }
        //Si il n'y a pas d'erreurs alors on tente notre requête
        if ($this->mMusic->updateMusique($titre, $desc, $pathMusique, $pathImage, $type, $idEditMusique) && $errorFlag == false) {
            //Si il n'y a pas eu d'erreurs et que notre requête à fonctionner on tente l'upload
            if (move_uploaded_file($mediasMusiques['tmp_name'][0], $pathMusique) &&  move_uploaded_file($mediasImages['tmp_name'][0], $pathImage)) {
                //Si notre upload est bon alors on supprimer les ancienne images
                if ($monTitre[0]['Musique'] != $pathMusique) {
                    unlink($monTitre[0]['Musique']);
                }
                if ($monTitre[0]['ImagePochette'] != $pathImage) {
                    unlink($monTitre[0]['ImagePochette']);
                }
            } else {
                $errorFlag = true;
            }
        }
        //Si le flag d'erreur à été levé alors on rollback notre requête
        if ($errorFlag == true) {
            $pdo->rollBack();
        } else {
            //Sinon on commit notre requête
            $pdo->commit();
        }
    }
    /**
     * Fonction controlleur qui s'occupe de modifier un type
     *
     * @param [string] $nameType
     * @param [int] $idTypeToEdit
     * @return void
     */
    public function editType($nameType, $idTypeToEdit)
    {
        $this->mType->updateTypeById($idTypeToEdit, $nameType);
    }

    /**
     * Fonction controlleur qui s'occupe de supprimer une musique pour un id donnée
     *
     * @param [int] $IdMusiqueADelete
     * @return void
     */
    function delete($idMusiqueADelete)
    {
        $musique = $this->getTitreById($idMusiqueADelete);
        unlink($musique[0]['Musique']);
        unlink($musique[0]['ImagePochette']);
        $this->mMusic->deleteMusiqueById($idMusiqueADelete);
    }
    /**
     * Fonction controlleur qui s'occupe de supprimer un type pour un id donnée (Impossible)
     *
     * @param [type] $idTypeADelete
     * @return void
     */
    public function deleteType($idTypeADelete)
    {
        $this->mType->deleteTypeById($idTypeADelete);
    }

    /**
     * Fonction controlleur qui s'occupe de vérifier les types des fichiers donnés
     *
     * @param [music] $fileMusic
     * @param [img] $fileImage
     * @return void
     */
    function checkFilesType($fileMusic, $fileImage)
    {
        //Traitement
        $typeOk = true;
        //On récupère nos type des médias
        $fileTypeMusic = mime_content_type($fileMusic['tmp_name'][0]);
        $fileTypeImage = mime_content_type($fileImage['tmp_name'][0]);
        if (strpos($fileTypeMusic, 'audio/') === false) {
            $typeOk = false;
        }
        if (strpos($fileTypeImage, 'image/') === false) {
            $typeOk = false;
        }
        //Sortie
        return $typeOk;
    }

    /**
     * Fonction controlleur qui s'occupe de vérifier la tailles des fichiers données.
     *
     * @param [music] $fileMusic
     * @param [img] $fileImage
     * @return void
     */
    public function checkFilesSize($fileMusic, $fileImage)
    {
        //Traitement
        $sizeOk = true;
        //On vérifie qu'on ne dépasse pas la taille max de chaque médias(variable environnement pour la taille max)
        if ($fileMusic['size'][0] > MAX_FILESIZE_AUDIO) {
            $sizeOk = false;
        }
        if ($fileImage['size'][0] > MAX_FILESIZE_IMAGE) {
            $sizeOk = false;
        }
        //Sortie
        return $sizeOk;
    }
}
