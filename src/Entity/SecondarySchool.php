<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SecondarySchoolRepository")
 */
class SecondarySchool
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string",length=15)
     * @ORM\Id

     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="schoolname", type="string", length=255)
     */
    private $schoolname;

    /**
     * @var string
     *
     * @ORM\Column(name="schooltype", type="string", length=10, nullable=true)
     */
    private $schooltype;

    /**
     * @var string
     *
     * @ORM\Column(name="schoolkind", type="string", length=10, nullable=true)
     */
    private $schoolkind;

    /**
     * @var string
     *
     * @ORM\Column(name="town", type="string", length=255, nullable=true)
     */
    private $town;




    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Student", mappedBy="wish1")
     */
    private $students;



    public function __construct()
    {
        $this->students = new ArrayCollection();
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
     * @return SecondarySchool
     */
    public function setStudents(ArrayCollection $students): SecondarySchool
    {
        $this->students = $students;
        return $this;
    }






    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return SecondarySchool
     */
    public function setId(string $id): SecondarySchool
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getSchoolname(): string
    {
        return $this->schoolname;
    }

    /**
     * @param string $schoolname
     * @return SecondarySchool
     */
    public function setSchoolname(string $schoolname): SecondarySchool
    {
        $this->schoolname = $schoolname;
        return $this;
    }

    /**
     * @return string
     */
    public function getSchooltype(): string
    {
        return $this->schooltype;
    }

    /**
     * @param string $schooltype
     * @return SecondarySchool
     */
    public function setSchooltype(string $schooltype): SecondarySchool
    {
        $this->schooltype = $schooltype;
        return $this;
    }

    /**
     * @return string
     */
    public function getSchoolkind(): string
    {
        return $this->schoolkind;
    }

    /**
     * @param string $schoolkind
     * @return SecondarySchool
     */
    public function setSchoolkind(string $schoolkind): SecondarySchool
    {
        $this->schoolkind = $schoolkind;
        return $this;
    }

    /**
     * @return string
     */
    public function getTown(): string
    {
        return $this->town;
    }

    /**
     * @param string $town
     * @return SecondarySchool
     */
    public function setTown(string $town): SecondarySchool
    {
        $this->town = $town;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDrenddn()
    {
        return $this->drenddn;
    }

    /**
     * @param mixed $drenddn
     * @return SecondarySchool
     */
    public function setDrenddn($drenddn)
    {
        $this->drenddn = $drenddn;
        return $this;
    }


    /**

     * @ORM\ManyToOne(targetEntity="App\Entity\Drenddn")

     * @ORM\JoinColumn(nullable=false)

     */

    private $drenddn;
}
