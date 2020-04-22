<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserieppRepository")
 */
class Useriepp
{
    /**
     * @return string
     */
    public function getUserid(): string
    {
        return $this->userid;
    }

    /**
     * @param string $userid
     * @return Useriepp
     */
    public function setUserid(string $userid): Useriepp
    {
        $this->userid = $userid;
        return $this;
    }

    /**
     * @return string
     */
    public function getIeppid(): string
    {
        return $this->ieppid;
    }

    /**
     * @param string $ieppid
     * @return Useriepp
     */
    public function setIeppid(string $ieppid): Useriepp
    {
        $this->ieppid = $ieppid;
        return $this;
    }
    /**
     * @var string
     * @ORM\Column(name="userid", type="string", length=15)

     * @ORM\Id

     */
    private $userid;



    /**
     * @var string
     * @ORM\Column(name="ieppid", type="string", length=15)

     * @ORM\Id

     */
    private $ieppid;



}
