<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SocialConditionsRepository")
 */
class SocialConditions
{
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return SocialConditions
     */
    public function setId(string $id): SocialConditions
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return SocialConditions
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Student", mappedBy="father_job")
     */
    private $students;

    /**
     * @return ArrayCollection
     */
    public function getStudents(): ArrayCollection
    {
        return $this->students;
    }

    /**
     * @param ArrayCollection $students
     * @return SocialConditions
     */
    public function setStudents(ArrayCollection $students): SocialConditions
    {
        $this->students = $students;
        return $this;
    }


    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

}
