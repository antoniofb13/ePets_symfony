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

    #[ORM\ManyToOne(inversedBy: 'adopciones')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $id_user = null;

    #[ORM\OneToOne(inversedBy: 'adopcion', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?animales $id_animal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?user
    {
        return $this->id_user;
    }

    public function setIdUser(?user $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdAnimal(): ?animales
    {
        return $this->id_animal;
    }

    public function setIdAnimal(animales $id_animal): self
    {
        $this->id_animal = $id_animal;

        return $this;
    }
}
