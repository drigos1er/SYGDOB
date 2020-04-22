<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DrenddnRepository")
 */
class Drenddn
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string",length=15)
     * @ORM\Id

     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $drenname;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDrenname(): ?string
    {
        return $this->drenname;
    }

    public function setDrenname(string $drenname): self
    {
        $this->drenname = $drenname;

        return $this;
    }
}
