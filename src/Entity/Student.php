<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 * @UniqueEntity(fields={"id"},
 * message="Ce matricule est dejà utilisé "
 * )
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Locality", inversedBy="students")
     * @ORM\JoinColumn(name="locality_id", referencedColumnName="id",onDelete="SET NULL")
     */
    private $localities;








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
     * @ORM\Column(name="dren", type="string", length=15)
     */
    private $dren;

    /**
     *
     */
    public function getDren()
    {
        return $this->dren;
    }

    /**
     *
     * @return Student
     */
    public function setDren( $dren): Student
    {
        $this->dren = $dren;
        return $this;
    }









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
     * @ORM\ManyToOne(targetEntity="App\Entity\SocialConditions", inversedBy="students")
     * @ORM\JoinColumn(name="father_job", referencedColumnName="id",onDelete="SET NULL")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\SocialConditions", inversedBy="students")
     * @ORM\JoinColumn(name="mother_job", referencedColumnName="id",onDelete="SET NULL")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\SecondarySchool", inversedBy="students")
     * @ORM\JoinColumn(name="wish1", referencedColumnName="id",onDelete="SET NULL")
     */
    private $wish1;












    /**
     * @var string
     *
     * @Assert\NotEqualTo(propertyPath="wish1", message="Le voeu 2 doit être différent du voeu 1")
     * @ORM\ManyToOne(targetEntity="App\Entity\SecondarySchool", inversedBy="students")
     * @ORM\JoinColumn(name="wish2", referencedColumnName="id",onDelete="SET NULL")
     */
    private $wish2;









    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\SecondarySchool", inversedBy="students")
     * @ORM\JoinColumn(name="wish3", referencedColumnName="id",onDelete="SET NULL")
     */
    private $wish3;



    /**
     * @var string
     *
     * @ORM\Column(name="valid_wish", type="string", length=1,nullable=true)
     */
    private $validwish;


    /**
     * @var string
     *
     * @ORM\Column(name="upd_birthdate", type="string", length=1,nullable=true)
     */
    private $updatebirthdate;

    /**
     * @return string
     */
    public function getUpdatebirthdate(): string
    {
        return $this->updatebirthdate;
    }

    /**
     * @param string $updatebirthdate
     * @return Student
     */
    public function setUpdatebirthdate(string $updatebirthdate): Student
    {
        $this->updatebirthdate = $updatebirthdate;
        return $this;
    }




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
     *
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLocalities()
    {
        return $this->localities;
    }

    /**
     * @param mixed $localities
     * @return Student
     */
    public function setLocalities($localities)
    {
        $this->localities = $localities;
        return $this;
    }

    /**
     *
     * @return Student
     */
    public function setId( $id): Student
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     *
     * @return Student
     */
    public function setFirstname( $firstname): Student
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     *
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     *
     * @return Student
     */
    public function setLastname( $lastname): Student
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     *
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     *
     * @return Student
     */
    public function setBirthdate( $birthdate): Student
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
     *
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     *
     * @return Student
     */
    public function setKind($kind): Student
    {
        $this->kind = $kind;
        return $this;
    }

    /**
     *
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     *
     * @return Student
     */
    public function setNationality( $nationality): Student
    {
        $this->nationality = $nationality;
        return $this;
    }


    /**
     *
     */
    public function getResidence()
    {
        return $this->residence;
    }

    /**
     *
     * @return Student
     */
    public function setResidence($residence): Student
    {
        $this->residence = $residence;
        return $this;
    }

    /**
     *
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     *
     * @return Student
     */
    public function setSchool($school): Student
    {
        $this->school = $school;
        return $this;
    }

    /**
     *
     */
    public function getIepp()
    {
        return $this->iepp;
    }

    /**
     *
     * @return Student
     */
    public function setIepp( $iepp): Student
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
     *
     */
    public function getFathername()
    {
        return $this->fathername;
    }

    /**
     *
     * @return Student
     */
    public function setFathername( $fathername): Student
    {
        $this->fathername = $fathername;
        return $this;
    }

    /**
     *
     */
    public function getFathercontact()
    {
        return $this->fathercontact;
    }

    /**
     *
     * @return Student
     */
    public function setFathercontact( $fathercontact): Student
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
     *
     */
    public function getMothername()
    {
        return $this->mothername;
    }

    /**
     *
     * @return Student
     */
    public function setMothername( $mothername): Student
    {
        $this->mothername = $mothername;
        return $this;
    }

    /**
     *
     */
    public function getMothercontact()
    {
        return $this->mothercontact;
    }

    /**
     *
     * @return Student
     */
    public function setMothercontact($mothercontact): Student
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
     *
     */
    public function getTutorname()
    {
        return $this->tutorname;
    }

    /**
     *
     * @return Student
     */
    public function setTutorname( $tutorname): Student
    {
        $this->tutorname = $tutorname;
        return $this;
    }

    /**
     *
     */
    public function getTutorcontact()
    {
        return $this->tutorcontact;
    }

    /**
     * t
     * @return Student
     */
    public function setTutorcontact( $tutorcontact): Student
    {
        $this->tutorcontact = $tutorcontact;
        return $this;
    }

    /**
     *
     */
    public function getTutorjob()
    {
        return $this->tutorjob;
    }

    /**
     *
     * @return Student
     */
    public function setTutorjob($tutorjob): Student
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
     *
     * @return Student
     */
    public function setTypeofidoc( $typeofidoc): Student
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
     *
     * @return Student
     */
    public function setNumofidoc( $numofidoc): Student
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
     *
     */
    public function getValidwish()
    {
        return $this->validwish;
    }

    /**
     *
     * @return Student
     */
    public function setValidwish($validwish): Student
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
