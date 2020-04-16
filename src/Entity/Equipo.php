<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EquipoRepository")
 */
class Equipo
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
    private $Nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Escudo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Descripcion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Jugador", mappedBy="Equipo")
     */
    private $jugadors;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Entrenador", mappedBy="Equipo", cascade={"persist", "remove"})
     */
    private $entrenador;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Estadio", mappedBy="Equipo", cascade={"persist", "remove"})
     */
    private $estadio;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Partidos", mappedBy="equipoLocal")
     */
    private $partidos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Partidos", mappedBy="equipoVisitante")
     */
    private $partidosV;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Puntos;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $GolesFavor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $GolesContra;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="equipo", cascade={"persist", "remove"})
     */
    private $user;

    public function __construct()
    {
        $this->jugadors = new ArrayCollection();
        $this->partidos = new ArrayCollection();
        $this->partidosV = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString()
    {
        return $this->Nombre;
    }
    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): self
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getEscudo(): ?string
    {
        return $this->Escudo;
    }

    public function setEscudo(string $Escudo): self
    {
        $this->Escudo = $Escudo;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->Descripcion;
    }

    public function setDescripcion(?string $Descripcion): self
    {
        $this->Descripcion = $Descripcion;

        return $this;
    }

    /**
     * @return Collection|Jugador[]
     */
    public function getJugadors(): Collection
    {
        return $this->jugadors;
    }

    public function addJugador(Jugador $jugador): self
    {
        if (!$this->jugadors->contains($jugador)) {
            $this->jugadors[] = $jugador;
            $jugador->setEquipo($this);
        }

        return $this;
    }

    public function removeJugador(Jugador $jugador): self
    {
        if ($this->jugadors->contains($jugador)) {
            $this->jugadors->removeElement($jugador);
            // set the owning side to null (unless already changed)
            if ($jugador->getEquipo() === $this) {
                $jugador->setEquipo(null);
            }
        }

        return $this;
    }

    public function getEntrenador(): ?Entrenador
    {
        return $this->entrenador;
    }

    public function setEntrenador(?Entrenador $entrenador): self
    {
        $this->entrenador = $entrenador;

        // set (or unset) the owning side of the relation if necessary
        $newEquipo = null === $entrenador ? null : $this;
        if ($entrenador->getEquipo() !== $newEquipo) {
            $entrenador->setEquipo($newEquipo);
        }

        return $this;
    }

    public function getEstadio(): ?Estadio
    {
        return $this->estadio;
    }

    public function setEstadio(Estadio $estadio): self
    {
        $this->estadio = $estadio;

        // set the owning side of the relation if necessary
        if ($estadio->getEquipo() !== $this) {
            $estadio->setEquipo($this);
        }

        return $this;
    }

    /**
     * @return Collection|Partidos[]
     */
    public function getPartidos(): Collection
    {
        return $this->partidos;
    }

    public function addPartido(Partidos $partido): self
    {
        if (!$this->partidos->contains($partido)) {
            $this->partidos[] = $partido;
            $partido->setEquipoLocal($this);
        }

        return $this;
    }

    public function removePartido(Partidos $partido): self
    {
        if ($this->partidos->contains($partido)) {
            $this->partidos->removeElement($partido);
            // set the owning side to null (unless already changed)
            if ($partido->getEquipoLocal() === $this) {
                $partido->setEquipoLocal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PartidosV[]
     */
    public function getPartidosV(): Collection
    {
        return $this->partidosV;
    }

    public function getPuntos(): ?int
    {
        return $this->Puntos;
    }

    public function setPuntos(?int $Puntos): self
    {
        $this->Puntos = $Puntos;

        return $this;
    }

    public function getGolesFavor(): ?int
    {
        return $this->GolesFavor;
    }

    public function setGolesFavor(?int $GolesFavor): self
    {
        $this->GolesFavor = $GolesFavor;

        return $this;
    }

    public function getGolesContra(): ?int
    {
        return $this->GolesContra;
    }

    public function setGolesContra(?int $GolesContra): self
    {
        $this->GolesContra = $GolesContra;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        // set (or unset) the owning side of the relation if necessary
        $newEquipo = null === $user ? null : $this;
        if ($user->getEquipo() !== $newEquipo) {
            $user->setEquipo($newEquipo);
        }

        return $this;
    }
}
