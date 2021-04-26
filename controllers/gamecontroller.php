 <?php
    /**
     * Nom : Tayan
     * Prénom : Jad
     * Ecole : CFPT-Informatique
     * Date : 23.04.2021
     * Projet : TPI 2021
     * Fichier : gamecontroller.php
     */
    //Modèles nécessaire au controlleurs
    require_once("./models/Quizz.php");
    require_once("./models/Musiques.php");

    //Initialisation de mes variables pour ma vue
    $titres = array();
    $aDeviner = "";
    $typePartie = "";
    define("cent", 100);

    //Initialisation controlleur
    $ctrlg = new ControllerGame();

    if ($ctrlg->getNbMusic() < 4) {
        header("Location: index.php?uc=accueil");
        exit();
    }

    //Si on reçoit l'action start ça veut dire que on commence la partie
    if ($action == "start" && !isset($_SESSION['game']['hasStarted'])) {
        //On filtre ce qu'on reçoit
        $submit = filter_input(INPUT_POST, 'submitPlay', FILTER_SANITIZE_STRING);
        //On vérifie qu'on a bien envoyé le lancement depuis le formulaire
        if ($submit && !isset($_SESSION['game'])) {
            //Filtrages des données reçus
            $typePartie = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
            $nombrequestions = filter_input(INPUT_POST, 'nbQuestion', FILTER_SANITIZE_STRING);
            $temps = filter_input(INPUT_POST, 'slider', FILTER_SANITIZE_STRING);
            //On vérifie que tout le formulaire est rempli
            if (!empty($typePartie) && !empty($nombrequestions) && !empty($temps)) {
                //Initialisation des variables de parties
                $_SESSION['game'] = array();
                $_SESSION['game']['titresJoue'] = array();
                $_SESSION['game']['hasStarted'] = true;
                $_SESSION['game']['typePartie'] = $typePartie;
                $_SESSION['game']['nbQuestion'] = $nombrequestions;
                $_SESSION['game']['nbStep'] = 1;
                $_SESSION['game']['trueReponse'] = "";
                $_SESSION['game']['point'] = 0;
                $_SESSION['game']['timerMS'] = $temps * cent;
                //On récupère nos questions
                $titres = $ctrlg->getFourQuestion();
                $aDeviner = $ctrlg->getStep($titres, $typePartie);
                array_push($_SESSION['game']['titresJoue'], $_SESSION['game']['trueReponse']);
            } else {
                //Si ce n'est pas bon on renvoie à l'accueil
                header("Location: index.php?uc=accueil");
                exit();
            }
        }
    } else {
        //Dans le cas ou la partie à déjà commencé on passe juste la question
        $action = "next";
    }

    //Dans le cas ou l'action est next cela veut dire qu'on veut passer à la prochaine question
    if ($action == "next" && isset($_SESSION['game'])) {
        //On filtre la réponse reçu et on dit qu'on a avancé d'une question
        $reponsesentree = filter_input(INPUT_POST, 'reponses', FILTER_SANITIZE_STRING);
        $_SESSION['game']['nbStep'] += 1;
        //Dans le cas ou nous avons dépassé notre nombre de question total cela veut dire que la partie est terminé
        if ($_SESSION['game']['nbStep'] > $_SESSION['game']['nbQuestion']) {
            //On vérifie quand même si notre dernière question est juste dans ce cas on ajoute un point
            if ($reponsesentree == $_SESSION['game']['trueReponse'][0]['IdMusique']) {
                if ($_SESSION['game']['point'] < $_SESSION['game']['nbQuestion']) {
                    $_SESSION['game']['point'] += 1;
                }
            }
            //On récupère notre score et sauvegardons cette partie nous allons ensuite être redirigé vers la page de base
            $_SESSION['User']['Score'] = $_SESSION['game']['point'];
            header("Location: index.php?uc=accueil&action=score");
            exit();
        } else {
            //Si nous n'avons pas dépassé alors la partie continue, on vérifie notre réponse et récupérons des nouvelles données
            if ($reponsesentree == $_SESSION['game']['trueReponse'][0]['IdMusique']) {
                $_SESSION['game']['point'] += 1;
            }
            $titres = $ctrlg->getFourQuestion();
            array_push($_SESSION['game']['titresJoue'], $_SESSION['game']['trueReponse']);
            $aDeviner = $ctrlg->getStep($titres, $typePartie);
        }
    }

    //Si la session de jeu est présente on affiche le jeu
    if (isset($_SESSION['game'])) {
        //Affichage de la vue
        require_once("./views/games/game.php");
    }




    class ControllerGame
    {
        //Champs
        protected $mMusic;

        /**
         * Constructeur par défaut
         */
        public function __construct()
        {
            $this->mMusic = new Musiques();
        }

        /**
         * Fonction controlleur qui s'occupe de nous tirés 4 titres aléatoires
         *
         * @return array
         */
        public function getFourQuestion()
        {
            //Initialisation
            $titres = array();
            $idDejaTire = array();
            $RND = 0;
            $nbMusique = $this->mMusic->getNumberOfMusique()['COUNT(*)'];
            //Traitement
            //Tant que on a pas 4 choix on continue d'en chercher
            while (count($titres) != 4) {
                $RND = rand(1, $nbMusique);
                //Comme on prend de manière aléatoire dans notre base on vérifie de ne pas tiré deux fois le même choix
                if (!in_array($RND, $idDejaTire)) {
                    $musiqueAQCM = $this->mMusic->getMusiqueById($RND);
                    //Ensuite on ajoute dans nos titres
                    array_push($titres, $musiqueAQCM);
                    array_push($idDejaTire, $RND);
                }
            }
            //Sortie
            return $titres;
        }
        /**
         * Fonction qui s'occupe du passage des questions
         *
         * @param [array] $titres
         * @param [string] $typePartie
         * @return string
         */
        public function getStep($titres, $typePartie)
        {
            //Initialisation
            $RND = 0;
            $RND = rand(0, 3);
            $aDeviner = "";
            $_SESSION['game']['trueReponse'] = $titres[$RND];
            //Traitement
            //Dans le cas ou mon type de partie est une chanson alors il faudra intégrer une balise audio
            if ($_SESSION['game']['typePartie'] == "chant") {
                $aDeviner = "<audio autoplay id='player'>" . "<source src='" .  $titres[$RND][0]['Musique'] . "#t=" . rand(50, 90) . "'>"  . "</audio>";
            }
            //Dans le cas ou mon type de partie est une chanson alors il faudra intégrer une balise image
            if ($_SESSION['game']['typePartie'] == "image") {
                $aDeviner = "<img src='" . $titres[$RND][0]['ImagePochette'] . "' width='200px' height='200px'/>";
            }
            //Sortie
            return $aDeviner;
        }
        public function getNbMusic()
        {
            return $this->mMusic->getNumberOfMusique()['COUNT(*)'];
        }
    }
