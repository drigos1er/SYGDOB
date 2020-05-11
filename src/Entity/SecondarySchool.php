<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SecondarySchoolRepository")
 * @UniqueEntity(fields={"id"},
 * message="Ce code est dejà utilisé "
 * )
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
     *
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return SecondarySchool
     */
    public function setId($id): SecondarySchool
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     */
    public function getSchoolname()
    {
        return $this->schoolname;
    }

    /**
     *
     * @return SecondarySchool
     */
    public function setSchoolname($schoolname): SecondarySchool
    {
        $this->schoolname = $schoolname;
        return $this;
    }

    /**
     *
     */
    public function getSchooltype()
    {
        return $this->schooltype;
    }

    /**
     *
     * @return SecondarySchool
     */
    public function setSchooltype($schooltype): SecondarySchool
    {
        $this->schooltype = $schooltype;
        return $this;
    }

    /**
     *
     */
    public function getSchoolkind()
    {
        return $this->schoolkind;
    }

    /**
     * @param
     * @return SecondarySchool
     */
    public function setSchoolkind( $schoolkind): SecondarySchool
    {
        $this->schoolkind = $schoolkind;
        return $this;
    }

    /**
     *
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     *
     * @return SecondarySchool
     */
    public function setTown($town): SecondarySchool
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
