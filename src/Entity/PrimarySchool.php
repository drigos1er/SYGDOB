<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PrimarySchoolRepository")
 */
class PrimarySchool
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
    private $schoolname;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $town;




    /**

     * @ORM\ManyToOne(targetEntity="App\Entity\Drenddn")

     * @ORM\JoinColumn(nullable=false)

     */

    private $drenddn;



    /**

     * @ORM\ManyToOne(targetEntity="App\Entity\Iepp")

     * @ORM\JoinColumn(nullable=false)

     */

    private $iepp;



    public function getId()
    {
        return $this->id;
    }

    public function getSchoolname(): ?string
    {
        return $this->schoolname;
    }

    public function setSchoolname(string $schoolname): self
    {
        $this->schoolname = $schoolname;

        return $this;
    }



    public function getTown(): ?string
    {
        return $this->town;
    }

    public function setTown(string $town): self
    {
        $this->town = $town;

        return $this;
    }






    public function setDrenname(string $drenname): self
    {
        $this->drenname = $drenname;

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



    /**
     * Set ieppp
     *
     * @param Iepp $iepp
     * @return iepp
     */
    public function setIepp(Iepp $iepp)
    {
        $this->iepp = $iepp;

        return $this;
    }

    /**
     * Get iepp
     *
     * @return Iepp
     */
    public function getIepp()
    {
        return $this->iepp;
    }




}
