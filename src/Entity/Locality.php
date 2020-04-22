<?php

namespace App\Entity;

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
     * @return string
     */
    public function getLocality(): string
    {
        return $this->locality;
    }

    /**
     * @param string $locality
     * @return Locality
     */
    public function setLocality(string $locality): Locality
    {
        $this->locality = $locality;
        return $this;
    }



    /**
     * @var string
     * @ORM\Column(name="localityname", type="string", length=255)

     */
    private $locality;
}
