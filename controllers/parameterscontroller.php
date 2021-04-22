<?php
require_once("./models/parametres.php");
require_once("./models/Quizz.php");
require_once("./models/User_Parametres.php");
require_once("./models/Musiques_Quizz.php");


$score = 0;
$ctrlP = new ControllerParameters();
$selected = "";
$choixDesTypes = "";

if ($action == "score") {
    if (!isset($_SESSION['User']['Score'])) {
    } else {
        $score = $_SESSION['User']['Score'];
        $ctrlP->addQuiz($score);
        $lastidQuiz = Database::getPDO()->lastInsertId();
        var_dump($_SESSION['game']['titresJoue']);
        $ctrlP->saveMusicOfQuizz($_SESSION['game']['titresJoue'],$lastidQuiz);
        $ctrlP->create($_SESSION['game']['nbQuestion'], $_SESSION['game']['timerMS'] / 100, $_SESSION['game']['typePartie'], Database::getPDO()->lastInsertId());
        $lastidParam = Database::getPDO()->lastInsertId();
        $ctrlP->addUserParam($lastidParam, $_SESSION['User'][0]['IdUser']);
        unset($_SESSION['User']['Score']);
    }
    unset($_SESSION['game']);
}

if (!isset($_SESSION["User"])) {
    header("Location: ./index.php?uc=login");
    exit();
} else {
    $_SESSION['UserParam'] = $ctrlP->getParamOfUser($_SESSION["User"][0]['IdUser']);
    $tailletableau = count($_SESSION['UserParam']);
    if (!empty($_SESSION['UserParam'])) {
        for ($i = 10; $i <= 30; $i += 10) {
            if ($i == $_SESSION['UserParam'][$tailletableau - 1]['NbQuestions']) {
                $selected .= "<option selected value='" . $i . "'> " . $i . " Questions </option>";
            } else {
                $selected .= "<option value='" . $i . "'> " . $i . " Questions </option>";
            }
        }
        $rangeSlider = "<input type='range' class='slider' value='" . $_SESSION['UserParam'][$tailletableau - 1]['Temps'] . "' name='slider' id='slider1' min='5' max='20' oninput='UpdateSlider(this.value)'/>";

        if ($_SESSION['UserParam'][$tailletableau - 1]['TypePartie'] == "chant") {
            $choixDesTypes = "<input type='radio' id='chant' name='type' value='chant' checked> <label for='chant'>Chant</label> 
        <br>
        <input type='radio' id='image' name='type' value='image'> <label for='image'>Image</label>";
        } else {
            $choixDesTypes = "<input type='radio' id='chant' name='type' value='chant'> <label for='chant'>Chant</label> 
        <br>
        <input type='radio' id='image' name='type' value='image' checked> <label for='image'>Image</label>";
        }
    } else {

        $rangeSlider = "<input type='range' class='slider' value='" . 13 . "' name='slider' id='slider1' min='5' max='20' oninput='UpdateSlider(this.value)'/>";
        for ($i = 10; $i <= 30; $i += 10) {
            $selected .= "<option value='" . $i . "'> " . $i . "Questions </option>";
        }

        $choixDesTypes = "<input type='radio' id='chant' name='type' value='chant' checked> <label for='chant'>Chant</label> 
        <br>
        <input type='radio' id='image' name='type' value='image'> <label for='image'>Image</label>";
    }
    require_once("./views/games/accueil.php");
}




class ControllerParameters
{

    private $mParam;
    private $mQuizz;
    private $mUserParam;
    private $mMusicQuizz;

    public function __construct()
    {
        $this->mParam = new Parametres();
        $this->mQuizz = new Quizz();
        $this->mUserParam = new User_Parametres();
        $this->mMusicQuizz = new Musiques_Quizz();
    }

    public function show()
    {
        $_POST["Parameters"] = $this->mParam->getAllParameters();
    }
    public function create($NbQuestion, $temps, $typePartie, $IdQuizz)
    {
        if ($this->mParam->add($NbQuestion, $temps, $typePartie, $IdQuizz)) {
        }
    }

    public function addUserParam($IdParam, $IdUser)
    {
        $this->mUserParam->add($IdParam, $IdUser);
    }
    public function addQuiz($score)
    {
        $this->mQuizz->add($score);
    }
    public function getParamOfUser($idUser)
    {
        return $this->mParam->getParamByIdUser($idUser);
    }
    public function saveMusicOfQuizz($titresJoue, $IdQuiz)
    {
        foreach ($titresJoue as $key => $value) {
            $this->mMusicQuizz->add($value[0]['IdMusique'], $IdQuiz);
        }
    }
}
