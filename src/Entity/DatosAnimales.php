<?php

namespace App\Entity;

use App\Repository\DatosAnimalesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DatosAnimalesRepository::class)]
class DatosAnimales
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $tipo = null;

    #[ORM\Column(length: 100)]
    private ?string $raza = null;

    #[ORM\Column(length: 100)]
    private ?string $tamano = null;

    #[ORM\OneToOne(mappedBy: 'id_animal', cascade: ['persist', 'remove'])]
    private ?Adopcion $id_adopcion = null;

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

    public function getRaza(): ?string
    {
        return $this->raza;
    }

    public function setRaza(string $raza): self
    {
        $this->raza = $raza;

        return $this;
    }

    public function getTamano(): ?string
    {
        return $this->tamano;
    }

    public function setTamano(string $tamano): self
    {
        $this->tamano = $tamano;

        return $this;
    }

    public function getIdAdopcion(): ?Adopcion
    {
        return $this->id_adopcion;
    }

    public function setIdAdopcion(Adopcion $id_adopcion): self
    {
        // set the owning side of the relation if necessary
        if ($id_adopcion->getIdAnimal() !== $this) {
            $id_adopcion->setIdAnimal($this);
        }

        $this->id_adopcion = $id_adopcion;

        return $this;
    }
}
