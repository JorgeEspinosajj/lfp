<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrenadorRepository")
 */
class Entrenador
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
    private $Nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Foto;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nacionalidad;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Equipo", inversedBy="entrenador", cascade={"persist", "remove"})
     */
    private $Equipo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }
    public function __toString(){
        return $this->Nombre;
    }
    public function setNombre(string $Nombre): self
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->Foto;
    }

    public function setFoto(string $Foto): self
    {
        $this->Foto = $Foto;

        return $this;
    }

    public function getNacionalidad(): ?string
    {
        return $this->Nacionalidad;
    }

    public function setNacionalidad(string $Nacionalidad): self
    {
        $this->Nacionalidad = $Nacionalidad;

        return $this;
    }

    public function getEquipo(): ?Equipo
    {
        return $this->Equipo;
    }

    public function setEquipo(?Equipo $Equipo): self
    {
        $this->Equipo = $Equipo;

        return $this;
    }
}
