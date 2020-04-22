<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class UpdPwd
{


    private $oldpwd;


    /**
     * @Assert\Length(min="6", minMessage="Votre mot de passe doit faire minimum 6 caractères")
     */
    private $newpwd;
    /**
     * @Assert\EqualTo(propertyPath="newpwd", message="Veuillez saisir un mot de passe identique")
     */
    private $confirmpwd;



    /**
     * @return mixed
     */
    public function getOldpwd()
    {
        return $this->oldpwd;
    }

    /**
     * @param mixed $oldpwd
     * @return Updpwd
     */
    public function setOldpwd($oldpwd)
    {
        $this->oldpwd = $oldpwd;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNewpwd()
    {
        return $this->newpwd;
    }

    /**
     * @param mixed $newpwd
     * @return Updpwd
     */
    public function setNewpwd($newpwd)
    {
        $this->newpwd = $newpwd;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfirmpwd()
    {
        return $this->confirmpwd;
    }

    /**
     * @param mixed $confirmpwd
     * @return Updpwd
     */
    public function setConfirmpwd($confirmpwd)
    {
        $this->confirmpwd = $confirmpwd;
        return $this;
    }
}