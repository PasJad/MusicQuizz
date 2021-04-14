<?php
require_once("./models/users.php");
class ControllerRegister
{

    protected $mUser;

    public function __construct()
    {
        $this->mUser = new Users();
    }

    public function show()
    {
        //TODO Montrer tout les utilisateurs 

    }

    /**
     * Fonction de création de compte et redirection
     *
     * @param [type] $pPseudo
     * @param [type] $pMail
     * @param [type] $pMdp
     * @param [type] $pStatut
     * @return void
     */
    public function create($pPseudo, $pMail,$pMdp,$pStatut)
    {   // ? Peut-être que le Hashage n'est pas bien placé
        $hpswd = password_hash($pMdp,PASSWORD_DEFAULT);
        if ($this->mUser->add($pPseudo,$pMail,$hpswd,$pStatut)) 
        {
            header("Location: " . "../views/games/game.php");
        }
    }
    function edit()
    {
    }
    function delete()
    {
    }
    /**
     * Get the value of mUser
     */ 
    public function getMUser()
    {
        return $this->mUser;
    }

    /**
     * Set the value of mUser
     *
     * @return  self
     */ 
    public function setMUser($mUser)
    {
        $this->mUser = $mUser;

        return $this;
    }
}
