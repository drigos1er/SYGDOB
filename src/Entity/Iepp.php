<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IeppRepository")
 */
class Iepp
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=15)
     * @ORM\Id

     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ieppname;



    /**

     * @ORM\ManyToOne(targetEntity="App\Entity\Drenddn")

     * @ORM\JoinColumn(nullable=false)

     */

    private $drenddn;




    public function getId()
    {
        return $this->id;
    }

    public function getIeppname(): ?string
    {
        return $this->ieppname;
    }

    public function setIeppname(string $ieppname): self
    {
        $this->ieppname = $ieppname;

        return $this;
    }


    /**
     * Set drenddn
     *
     * @param Drenddn $drenddn
     * @return drenddn
     */
    public function setDrenddn(Drenddn $drenddn)
    {
        $this->drenddn = $drenddn;

        return $this;
    }

    /**
     * Get drenddn
     *
     * @return Drenddn
     */
    public function getDrenddn()
    {
        return $this->drenddn;
    }





}
