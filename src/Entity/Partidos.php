<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartidosRepository")
 */
class Partidos
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipo", inversedBy="partidos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $equipoLocal;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipo", inversedBy="partidosV")
     * @ORM\JoinColumn(nullable=false)
     */
    private $equipoVisitante;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $golesLocal;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $golesVisitante;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $resultado;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ResultadoV;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipoLocal(): ?Equipo
    {
        return $this->equipoLocal;
    }

    public function setEquipoLocal(?Equipo $equipoLocal): self
    {
        $this->equipoLocal = $equipoLocal;

        return $this;
    }

    public function getEquipoVisitante(): ?Equipo
    {
        return $this->equipoVisitante;
    }

    public function setEquipoVisitante(?Equipo $equipoVisitante): self
    {
        $this->equipoVisitante = $equipoVisitante;

        return $this;
    }

    public function getGolesLocal(): ?int
    {
        return $this->golesLocal;
    }

    public function setGolesLocal(?int $golesLocal): self
    {
        $this->golesLocal = $golesLocal;

        return $this;
    }

    public function getGolesVisitante(): ?int
    {
        return $this->golesVisitante;
    }

    public function setGolesVisitante(?int $golesVisitante): self
    {
        $this->golesVisitante = $golesVisitante;

        return $this;
    }

    public function getResultado(): ?string
    {
        return $this->resultado;
    }

    public function setResultado(?string $resultado): self
    {
        $this->resultado = $resultado;

        return $this;
    }

    public function getResultadoV(): ?string
    {
        return $this->ResultadoV;
    }

    public function setResultadoV(?string $ResultadoV): self
    {
        $this->ResultadoV = $ResultadoV;

        return $this;
    }
}
