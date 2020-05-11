<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SygdobUserRepository")
 * @UniqueEntity(fields={"username"},
 * message="Ce nom d'utilisateur est dejà utilisé"
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class SygdobUser implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $gender;



    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $phone;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;




    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $picture;



    /**
     * @ORM\Column(name="user_role",type="string", length=150, nullable=true)
     */
    private $userrole;








    /**
     * @ORM\Column(name="user_structure",type="string", length=15, nullable=true)
     *
     */
    private $userstructure;

    /**
     * @return mixed
     */
    public function getUserstructure()
    {
        return $this->userstructure;
    }

    /**
     * @param mixed $userstructure
     * @return SygdobUser
     */
    public function setUserstructure($userstructure)
    {
        $this->userstructure = $userstructure;
        return $this;
    }




    /**
     * @return mixed
     */
    public function getUserrole()
    {
        return $this->userrole;
    }

    /**
     * @param mixed $userrole
     * @return SygdobUser
     */
    public function setUserrole($userrole)
    {
        $this->userrole = $userrole;
        return $this;
    }





    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $updprofil;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $enabled;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $last_login;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="6", minMessage="Votre mot de passe doit faire minimum 6 caractères")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @return mixed
     */
    public function getUsercreat()
    {
        return $this->usercreat;
    }

    /**
     * @param mixed $usercreat
     * @return SygdobUser
     */
    public function setUsercreat($usercreat)
    {
        $this->usercreat = $usercreat;
        return $this;
    }

    /**
     * @ORM\Column(type="datetime")
     */
    private $creatdat;

    /**
     * @ORM\Column(name="usercreat",type="string", length=100, nullable=true)
     */
    private $usercreat;


    /**
     * @ORM\Column(type="datetime")
     */
    private $upddat;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $tokendat;



    /**
     * @Assert\EqualTo(propertyPath="password", message="Veuillez saisir un mot de passe identique")
     */
    public $confirm_password;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SygdobRole", mappedBy="sygdobusers")
     */
    private $sygdobRoles;

    public function __construct()
    {
        $this->sygdobRoles = new ArrayCollection();
    }



    /**
     * Permet de générer la date de création et de modification
     * @ORM\PrePersist
     * @throws \Exception
     */
    public function prePersist()
    {
        if (empty($this->creatdat)) {
            $this->creatdat =new \DateTime();
        }

        if (empty($this->upddat)) {
            $this->upddat=new \DateTime();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }



    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }



    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }






    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture( $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getUpdprofil(): ?bool
    {
        return $this->updprofil;
    }

    public function setUpdprofil(bool $updprofil): self
    {
        $this->updprofil = $updprofil;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->last_login;
    }

    public function setLastLogin(\DateTimeInterface $last_login): self
    {
        $this->last_login = $last_login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getCreatdat(): ?\DateTimeInterface
    {
        return $this->creatdat;
    }

    public function setCreatdat(\DateTimeInterface $creatdat): self
    {
        $this->creatdat = $creatdat;

        return $this;
    }

    public function getUpddat(): ?\DateTimeInterface
    {
        return $this->upddat;
    }

    public function setUpddat(\DateTimeInterface $upddat): self
    {
        $this->upddat = $upddat;

        return $this;
    }

    public function getTokendat()
    {
        return $this->tokendat;
    }

    public function setTokendat( $tokendat): self
    {
        $this->tokendat = $tokendat;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        $roles=$this->sygdobRoles->map(function ($sygdobRoles) {

            return $sygdobRoles->getTitle();
        }
        )->toArray();

        $roles[]= 'ROLE_USER';

        return $roles;

    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection|SydobRole[]
     */
    public function getSygdobRoles(): Collection
    {
        return $this->sygdobRoles;
    }

    public function addSygdobRole(SygdobRole $sygdobRole): self
    {
        if (!$this->sygdobRoles->contains($sygdobRole)) {
            $this->sygdobRoles[] = $sygdobRole;
            $sygdobRole->addSygdobuser($this);
        }

        return $this;
    }

    public function removeSygdobRole(SygdobRole $sygdobRole): self
    {
        if ($this->sygdobRoles->contains($sygdobRole)) {
            $this->sygdobRoles->removeElement($sygdobRole);
            $sygdobRole->removeSygdobuser($this);
        }

        return $this;
    }
}
