<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 */
class Student
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
     * @ORM\Column(name="firstname", type="string", length=100)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="date")
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="placeofbirth", type="string", length=255,nullable=true)
     */
    private $placeofbirth;







    /**
     * @var string
     *
     * @ORM\Column(name="kind", type="string", length=1)
     */
    private $kind;



    /**
     * @var string
     *
     * @ORM\Column(name="nationality", type="string", length=15)
     */
    private $nationality;




    /**
     * @var string
     *
     * @ORM\Column(name="locality", type="string", length=15)
     */
    private $locality;



    /**
     * @var string
     *
     * @ORM\Column(name="residence", type="string", length=255)
     */
    private $residence;


    /**
     * @var string
     *
     * @ORM\Column(name="school", type="string", length=15)
     */
    private $school;

    /**
     * @var string
     *
     * @ORM\Column(name="iepp", type="string", length=15)
     */
    private $iepp;


    /**
     * @var string
     *
     * @ORM\Column(name="exam_center", type="string", length=15, nullable=true)
     */
    private $exam_center;



    /**
     * @var string
     *
     * @ORM\Column(name="father_name", type="string", length=255,nullable=true)
     */
    private $fathername;



    /**
     * @var string
     *
     * @ORM\Column(name="father_contact", type="string", length=25,nullable=true)
     */
    private $fathercontact;



    /**
     * @var string
     *
     * @ORM\Column(name="father_job", type="string", length=255)
     */
    private $fatherjob;





    /**
     * @var string
     *
     * @ORM\Column(name="mother_name", type="string", length=255,nullable=true)
     */
    private $mothername;





    /**
     * @var string
     *
     * @ORM\Column(name="mother_contact", type="string", length=25,nullable=true)
     */
    private $mothercontact;



    /**
     * @var string
     *
     * @ORM\Column(name="mother_job", type="string", length=255)
     */
    private $motherjob;




    /**
     * @var string
     *
     * @ORM\Column(name="tutor_name", type="string", length=255)
     */
    private $tutorname;




    /**
     * @var string
     *
     * @ORM\Column(name="tutor_contact", type="string", length=25)
     */
    private $tutorcontact;



    /**
     * @var string
     *
     * @ORM\Column(name="tutor_job", type="string", length=255)
     */
    private $tutorjob;




    /**
     * @var string
     *
     * @ORM\Column(name="typeof_iddoc", type="string", length=100)
     */
    private $typeofidoc;



    /**
     * @var string
     *
     * @ORM\Column(name="numof_iddoc", type="string", length=100)
     */
    private $numofidoc;




    /**
     * @var string
     *
     * @ORM\Column(name="wish1", type="string", length=15)
     */
    private $wish1;


    /**
     * @var string
     *
     * @ORM\Column(name="wish2", type="string", length=15)
     * @Assert\NotEqualTo(propertyPath="wish1", message="Le voeu2 doit être différent du voeu 1")
     */
    private $wish2;


    /**
     * @var string
     *
     * @ORM\Column(name="wish3", type="string", length=15,nullable=true)
     */
    private $wish3;



    /**
     * @var string
     *
     * @ORM\Column(name="valid_wish", type="string", length=1,nullable=true)
     */
    private $validwish;






    /**
     * @var \DateTime
     *
     * @ORM\Column(name="entry_date", type="datetime",nullable=true)
     */
    private $entrydate;

    /**
     * @var string
     *
     * @ORM\Column(name="entry_user", type="string", length=255,nullable=true)
     */
    private $entryuser;






    /**
     * @var \DateTime
     *
     * @ORM\Column(name="valid_date", type="datetime",nullable=true)
     */
    private $validdate;

    /**
     * @var string
     *
     * @ORM\Column(name="valid_user", type="string", length=255,nullable=true)
     */
    private $validuser;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Student
     */
    public function setId(string $id): Student
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return Student
     */
    public function setFirstname(string $firstname): Student
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return Student
     */
    public function setLastname(string $lastname): Student
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBirthdate(): \DateTime
    {
        return $this->birthdate;
    }

    /**
     * @param \DateTime $birthdate
     * @return Student
     */
    public function setBirthdate(\DateTime $birthdate): Student
    {
        $this->birthdate = $birthdate;
        return $this;
    }

    /**
     *
     */
    public function getPlaceofbirth()
    {
        return $this->placeofbirth;
    }

    /**
     *
     * @return Student
     */
    public function setPlaceofbirth( $placeofbirth): Student
    {
        $this->placeofbirth = $placeofbirth;
        return $this;
    }

    /**
     * @return string
     */
    public function getKind(): string
    {
        return $this->kind;
    }

    /**
     * @param string $kind
     * @return Student
     */
    public function setKind(string $kind): Student
    {
        $this->kind = $kind;
        return $this;
    }

    /**
     * @return string
     */
    public function getNationality(): string
    {
        return $this->nationality;
    }

    /**
     * @param string $nationality
     * @return Student
     */
    public function setNationality(string $nationality): Student
    {
        $this->nationality = $nationality;
        return $this;
    }

    /**
     *
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     *
     * @return Student
     */
    public function setLocality( $locality): Student
    {
        $this->locality = $locality;
        return $this;
    }

    /**
     * @return string
     */
    public function getResidence(): string
    {
        return $this->residence;
    }

    /**
     * @param string $residence
     * @return Student
     */
    public function setResidence(string $residence): Student
    {
        $this->residence = $residence;
        return $this;
    }

    /**
     * @return string
     */
    public function getSchool(): string
    {
        return $this->school;
    }

    /**
     * @param string $school
     * @return Student
     */
    public function setSchool(string $school): Student
    {
        $this->school = $school;
        return $this;
    }

    /**
     * @return string
     */
    public function getIepp(): string
    {
        return $this->iepp;
    }

    /**
     * @param string $iepp
     * @return Student
     */
    public function setIepp(string $iepp): Student
    {
        $this->iepp = $iepp;
        return $this;
    }

    /**
     * @return string
     */
    public function getExamCenter(): string
    {
        return $this->exam_center;
    }

    /**
     * @param string $exam_center
     * @return Student
     */
    public function setExamCenter(string $exam_center): Student
    {
        $this->exam_center = $exam_center;
        return $this;
    }

    /**
     * @return string
     */
    public function getFathername()
    {
        return $this->fathername;
    }

    /**
     * @param string $fathername
     * @return Student
     */
    public function setFathername(string $fathername): Student
    {
        $this->fathername = $fathername;
        return $this;
    }

    /**
     * @return string
     */
    public function getFathercontact()
    {
        return $this->fathercontact;
    }

    /**
     * @param string $fathercontact
     * @return Student
     */
    public function setFathercontact(string $fathercontact): Student
    {
        $this->fathercontact = $fathercontact;
        return $this;
    }

    /**
     *
     */
    public function getFatherjob()
    {
        return $this->fatherjob;
    }

    /**
     *
     * @return Student
     */
    public function setFatherjob($fatherjob): Student
    {
        $this->fatherjob = $fatherjob;
        return $this;
    }

    /**
     * @return string
     */
    public function getMothername()
    {
        return $this->mothername;
    }

    /**
     * @param string $mothername
     * @return Student
     */
    public function setMothername(string $mothername): Student
    {
        $this->mothername = $mothername;
        return $this;
    }

    /**
     * @return string
     */
    public function getMothercontact()
    {
        return $this->mothercontact;
    }

    /**
     * @param string $mothercontact
     * @return Student
     */
    public function setMothercontact(string $mothercontact): Student
    {
        $this->mothercontact = $mothercontact;
        return $this;
    }

    /**
     *
     */
    public function getMotherjob()
    {
        return $this->motherjob;
    }

    /**
     *
     * @return Student
     */
    public function setMotherjob( $motherjob): Student
    {
        $this->motherjob = $motherjob;
        return $this;
    }

    /**
     * @return string
     */
    public function getTutorname()
    {
        return $this->tutorname;
    }

    /**
     * @param string $tutorname
     * @return Student
     */
    public function setTutorname(string $tutorname): Student
    {
        $this->tutorname = $tutorname;
        return $this;
    }

    /**
     * @return string
     */
    public function getTutorcontact()
    {
        return $this->tutorcontact;
    }

    /**
     * @param string $tutorcontact
     * @return Student
     */
    public function setTutorcontact(string $tutorcontact): Student
    {
        $this->tutorcontact = $tutorcontact;
        return $this;
    }

    /**
     * @return string
     */
    public function getTutorjob()
    {
        return $this->tutorjob;
    }

    /**
     * @param string $tutorjob
     * @return Student
     */
    public function setTutorjob(string $tutorjob): Student
    {
        $this->tutorjob = $tutorjob;
        return $this;
    }

    /**
     * @return string
     */
    public function getTypeofidoc()
    {
        return $this->typeofidoc;
    }

    /**
     * @param string $typeofidoc
     * @return Student
     */
    public function setTypeofidoc(string $typeofidoc): Student
    {
        $this->typeofidoc = $typeofidoc;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumofidoc()
    {
        return $this->numofidoc;
    }

    /**
     * @param string $numofidoc
     * @return Student
     */
    public function setNumofidoc(string $numofidoc): Student
    {
        $this->numofidoc = $numofidoc;
        return $this;
    }

    /**
     *
     */
    public function getWish1()
    {
        return $this->wish1;
    }

    /**
     *
     * @return Student
     */
    public function setWish1($wish1): Student
    {
        $this->wish1 = $wish1;
        return $this;
    }

    /**
     *
     */
    public function getWish2()
    {
        return $this->wish2;
    }

    /**
     *
     * @return Student
     */
    public function setWish2($wish2): Student
    {
        $this->wish2 = $wish2;
        return $this;
    }

    /**
     *
     */
    public function getWish3()
    {
        return $this->wish3;
    }

    /**
     *
     * @return Student
     */
    public function setWish3($wish3): Student
    {
        $this->wish3 = $wish3;
        return $this;
    }

    /**
     * @return string
     */
    public function getValidwish(): string
    {
        return $this->validwish;
    }

    /**
     * @param string $validwish
     * @return Student
     */
    public function setValidwish(string $validwish): Student
    {
        $this->validwish = $validwish;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEntrydate(): \DateTime
    {
        return $this->entrydate;
    }

    /**
     * @param \DateTime $entrydate
     * @return Student
     */
    public function setEntrydate(\DateTime $entrydate): Student
    {
        $this->entrydate = $entrydate;
        return $this;
    }

    /**
     * @return string
     */
    public function getEntryuser(): string
    {
        return $this->entryuser;
    }

    /**
     * @param string $entryuser
     * @return Student
     */
    public function setEntryuser(string $entryuser): Student
    {
        $this->entryuser = $entryuser;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getValiddate(): \DateTime
    {
        return $this->validdate;
    }

    /**
     * @param \DateTime $validdate
     * @return Student
     */
    public function setValiddate(\DateTime $validdate): Student
    {
        $this->validdate = $validdate;
        return $this;
    }

    /**
     * @return string
     */
    public function getValiduser(): string
    {
        return $this->validuser;
    }

    /**
     * @param string $validuser
     * @return Student
     */
    public function setValiduser(string $validuser): Student
    {
        $this->validuser = $validuser;
        return $this;
    }














}
