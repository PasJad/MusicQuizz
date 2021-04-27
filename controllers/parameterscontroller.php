<?php
/**
  * Nom : Tayan
  * Prénom : Jad
  * Ecole : CFPT-Informatique
  * Date : 27.04.2021
  * Projet : TPI 2021
  * Fichier : parameterscontroller.php
  */
//Modèles nécessaire au controlleurs
require_once("./models/parametres.php");
require_once("./models/Quizz.php");
require_once("./models/User_Parametres.php");
require_once("./models/Musiques_Quizz.php");

//Initialisation de mon controlleur
$ctrlP = new ControllerParameters();

//Initialisation de mes variable liés à ma vue
$score = 0;
$selected = "";
$choixDesTypes = "";
//Si l'action est score
if ($action == "score") {
    //On vérifie que notre score du user est initialisé (Sinon cela veut dire que nous n'avons pas fini de partie) 
    if (!isset($_SESSION['User']['Score'])) {
    } else {
        //Sinon on initialise notre variable de score
        $score = $_SESSION['User']['Score'];
        //Traitement
         //Après l'ajout du quiz on récupère l'id du dernier ajouté pour un futur insert
        $ctrlP->addQuiz($score);
        $lastidQuiz = Database::getPDO()->lastInsertId();
        //On sauvegarde nos musique du quiz
        $ctrlP->saveMusicOfQuizz($_SESSION['game']['titresJoue'],$lastidQuiz);
        //Création d'un paramètre utilisateurs
        $ctrlP->create($_SESSION['game']['nbQuestion'], $_SESSION['game']['timerMS'] / 100, $_SESSION['game']['typePartie'], $lastidQuiz);
        $lastidParam = Database::getPDO()->lastInsertId();
        //On ajoute à notre table de liaison utilisateurs et parametres les données qu'on vient de créer
        $ctrlP->addUserParam($lastidParam, $_SESSION['User'][0]['IdUser']);
        //On supprimer le score utilisateur
        unset($_SESSION['User']['Score']);
    }
    //Si on est arrivé ici cela veut dire que dans tout les cas la partie est terminé alors on supprimer notre session de jeu
    unset($_SESSION['game']);
}
//Si nous ne sommes pas connecté dans tout les on redirige à la page de connexion
if (!isset($_SESSION["User"])) {
    header("Location: ./index.php?uc=login");
    exit();
} else {
    //Sinon on récupère les parametres de notre utilisateurs
    $_SESSION['UserParam'] = $ctrlP->getParamOfUser($_SESSION["User"][0]['IdUser']);
    $tailleTableau = count($_SESSION['UserParam']);
    if (isset($_SESSION['UserParam'][$tailleTableau - 1]['Temps'])) {
        $vTemps = $_SESSION['UserParam'][$tailleTableau - 1]['Temps'];
    }
    else{
        $vTemps = 13;
    }
    //On vérifie que l'utilisateur à des paramètres (il a donc joué des parties)
    if (!empty($_SESSION['UserParam'])) {
        //On affiche dynamiquement l'affichage de nos paramètres selons les valeurs entrées
        for ($i = 10; $i <= 30; $i += 10) {
            if ($i == $_SESSION['UserParam'][$tailleTableau - 1]['NbQuestions']) {
                $selected .= "<option selected value='" . $i . "'> " . $i . " Questions </option>";
            } else {
                $selected .= "<option value='" . $i . "'> " . $i . " Questions </option>";
            }
        }
        $rangeSlider = "<input type='range' class='slider' value='" . $_SESSION['UserParam'][$tailleTableau - 1]['Temps'] . "' name='slider' id='slider1' min='5' max='20' oninput='UpdateSlider(this.value)'/>";

        if ($_SESSION['UserParam'][$tailleTableau - 1]['TypePartie'] == "chant") {
            $choixDesTypes = "<input type='radio' id='chant' name='type' value='chant' checked> <label for='chant'>Chant</label> 
        <br>
        <input type='radio' id='image' name='type' value='image'> <label for='image'>Image</label>";
        } else {
            $choixDesTypes = "<input type='radio' id='chant' name='type' value='chant'> <label for='chant'>Chant</label> 
        <br>
        <input type='radio' id='image' name='type' value='image' checked> <label for='image'>Image</label>";
        }
    } else {
        //Si l'utilisateurs n'a pas de paramètre on affiche l'affichage de base
        $rangeSlider = "<input type='range' class='slider' value='" . 13 . "' name='slider' id='slider1' min='5' max='20' oninput='UpdateSlider(this.value)'/>";
        for ($i = 10; $i <= 30; $i += 10) {
            $selected .= "<option value='" . $i . "'> " . $i . " Questions </option>";
        }

        $choixDesTypes = "<input type='radio' id='chant' name='type' value='chant' checked> <label for='chant'>Chant</label> 
        <br>
        <input type='radio' id='image' name='type' value='image'> <label for='image'>Image</label>";
    }
    //Ensuite on affiche notre page d'accueil
    require_once("./views/games/accueil.php");
}




class ControllerParameters
{
    //Champs
    private $mParam;
    private $mQuizz;
    private $mUserParam;
    private $mMusicQuizz;

    /**
     * Constructeurs par défauts
     */
    public function __construct()
    {
        $this->mParam = new Parametres();
        $this->mQuizz = new Quizz();
        $this->mUserParam = new User_Parametres();
        $this->mMusicQuizz = new Musiques_Quizz();
    }

    /**
     * Fonction controlleur qui retournes tout les paramètres d'un utilisateurs
     *
     * @return void
     */
    public function show()
    {
        $_POST["Parameters"] = $this->mParam->getAllParameters();
    }
    /**
     * Fonction controlleur qui s'occupe de créer les paramètres
     *
     * @param int $nbQuestion
     * @param int $temps
     * @param string $typePartie
     * @param int $idQuizz
     * @return void
     */
    public function create($nbQuestion, $temps, $typePartie, $idQuizz)
    {
        $this->mParam->add($nbQuestion, $temps, $typePartie, $idQuizz);
    }

    /**
     * Fonction controlleur qui s'occupe d'ajouter les parametres liés au users dans la base
     *
     * @param int $idParam
     * @param int $idUser
     * @return void
     */
    public function addUserParam($idParam, $idUser)
    {
        $this->mUserParam->add($idParam, $idUser);
    }
    /**
     * Fonction controlleur qui s'occupe d'ajouter un quizz
     *
     * @param int $score
     * @return void
     */
    public function addQuiz($score)
    {
        $this->mQuizz->add($score);
    }
    /**
     * Fonction controlleur qui s'occupe de récupérer les paramètres d'un utilisateur avec un id donnée 
     *
     * @param int $idUser
     * @return array
     */
    public function getParamOfUser($idUser)
    {
        return $this->mParam->getParamByIdUser($idUser);
    }
    /**
     * Fonction controlleur qui s'occupe de sauvegarder les musiques liés au quiz dans la base
     *
     * @param array $titresJoue
     * @param int $idQuiz
     * @return void
     */
    public function saveMusicOfQuizz($titresJoue, $idQuiz)
    {
        $idDejaTire = array();
        foreach ($titresJoue as $key => $value) {
            if (!in_array($value[0]['IdMusique'], $idDejaTire)) {
                $this->mMusicQuizz->add($value[0]['IdMusique'], $idQuiz);
                //Ensuite on ajoute dans nos titres
                array_push($idDejaTire, $value[0]['IdMusique']);
            }
        }
    }
}
