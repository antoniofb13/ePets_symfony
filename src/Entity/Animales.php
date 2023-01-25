<?php

namespace App\Entity;

use App\Repository\AnimalesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalesRepository::class)]
class Animales
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tipo = null;

    #[ORM\Column(length: 255)]
    private ?string $raza = null;

    #[ORM\Column(length: 255)]
    private ?string $tamano = null;

    #[ORM\OneToOne(mappedBy: 'animal', cascade: ['persist', 'remove'])]
    private ?Adopcion $adopcion = null;

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

    public function getAdopcion(): ?Adopcion
    {
        return $this->adopcion;
    }

    public function setAdopcion(Adopcion $adopcion): self
    {
        // set the owning side of the relation if necessary
        if ($adopcion->getAnimal() !== $this) {
            $adopcion->setAnimal($this);
        }

        $this->adopcion = $adopcion;

        return $this;
    }
}
