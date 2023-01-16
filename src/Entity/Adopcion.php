<?php

namespace App\Entity;

use App\Repository\AdopcionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdopcionRepository::class)]
class Adopcion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'id_usuario_adopcion')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $id_user = null;

    #[ORM\OneToOne(inversedBy: 'id_adopcion', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?DatosAnimales $id_animal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?Usuario
    {
        return $this->id_user;
    }

    public function setIdUser(?Usuario $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdAnimal(): ?DatosAnimales
    {
        return $this->id_animal;
    }

    public function setIdAnimal(DatosAnimales $id_animal): self
    {
        $this->id_animal = $id_animal;

        return $this;
    }
}
