<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EstadioRepository")
 */
class Estadio
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
     * @ORM\Column(type="integer")
     */
    private $Capacidad;

    /**
     * @ORM\Column(type="date")
     */
    private $Fecha_Ing;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Ciudad;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Equipo", inversedBy="estadio", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
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

    public function getCapacidad(): ?int
    {
        return $this->Capacidad;
    }

    public function setCapacidad(int $Capacidad): self
    {
        $this->Capacidad = $Capacidad;

        return $this;
    }

    public function getFechaIng(): ?\DateTimeInterface
    {
        return $this->Fecha_Ing;
    }

    public function setFechaIng(\DateTimeInterface $Fecha_Ing): self
    {
        $this->Fecha_Ing = $Fecha_Ing;

        return $this;
    }

    public function getCiudad(): ?string
    {
        return $this->Ciudad;
    }

    public function setCiudad(string $Ciudad): self
    {
        $this->Ciudad = $Ciudad;

        return $this;
    }

    public function getEquipo(): ?Equipo
    {
        return $this->Equipo;
    }

    public function setEquipo(Equipo $Equipo): self
    {
        $this->Equipo = $Equipo;

        return $this;
    }
}
