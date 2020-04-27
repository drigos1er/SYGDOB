<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocalityRepository")
 */
class Locality
{
    /**
     * @var string
     * @ORM\Column(name="id", type="string", length=15)

     * @ORM\Id

     */
    private $id;



    /**
     * @var string
     * @ORM\Column(name="drenddn", type="string", length=15)

     */
    private $drenddn;









    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Locality
     */
    public function setId(string $id): Locality
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getDrenddn(): string
    {
        return $this->drenddn;
    }

    /**
     * @param string $drenddn
     * @return Locality
     */
    public function setDrenddn(string $drenddn): Locality
    {
        $this->drenddn = $drenddn;
        return $this;
    }





    /**
     * @var string
     * @ORM\Column(name="localityname", type="string", length=255)

     */
    private $localityname;

    /**
     * @return string
     */
    public function getLocalityname(): string
    {
        return $this->localityname;
    }

    /**
     * @param string $localityname
     * @return Locality
     */
    public function setLocalityname(string $localityname): Locality
    {
        $this->localityname = $localityname;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getStudents(): ArrayCollection
    {
        return $this->students;
    }

    /**
     * @param ArrayCollection $students
     * @return Locality
     */
    public function setStudents(ArrayCollection $students): Locality
    {
        $this->students = $students;
        return $this;
    }




    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Student", mappedBy="localities")
     */
    private $students;



    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

}
