<?php

namespace App\Entity;

use App\Repository\RolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RolRepository::class)]
class Rol
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $tipo = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\OneToMany(mappedBy: 'id_rol', targetEntity: Usuario::class, orphanRemoval: true)]
    private Collection $id_rol;

    public function __construct()
    {
        $this->id_rol = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection<int, Usuario>
     */
    public function getIdRol(): Collection
    {
        return $this->id_rol;
    }

    public function addIdRol(Usuario $idRol): self
    {
        if (!$this->id_rol->contains($idRol)) {
            $this->id_rol->add($idRol);
            $idRol->setIdRol($this);
        }

        return $this;
    }

    public function removeIdRol(Usuario $idRol): self
    {
        if ($this->id_rol->removeElement($idRol)) {
            // set the owning side to null (unless already changed)
            if ($idRol->getIdRol() === $this) {
                $idRol->setIdRol(null);
            }
        }

        return $this;
    }
}
