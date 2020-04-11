<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SygdobRoleRepository")
 */
class SygdobRole
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SygdobUser", inversedBy="sygdobRoles")
     */
    private $sygdobusers;

    public function __construct()
    {
        $this->sygdobusers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|SygdobUser[]
     */
    public function getSygdobusers(): Collection
    {
        return $this->sygdobusers;
    }

    public function addSygdobuser(SygdobUser $sygdobuser): self
    {
        if (!$this->sygdobusers->contains($sygdobuser)) {
            $this->sygdobusers[] = $sygdobuser;
        }

        return $this;
    }

    public function removeSygdobuser(SygdobUser $sygdobuser): self
    {
        if ($this->sygdobusers->contains($sygdobuser)) {
            $this->sygdobusers->removeElement($sygdobuser);
        }

        return $this;
    }
}
