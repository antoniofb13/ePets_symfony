<?php

namespace App\Entity;

use App\Repository\DatosProtectoraRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DatosProtectoraRepository::class)]
class DatosProtectora
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $direccion = null;

    #[ORM\Column(nullable: true)]
    private ?int $capacidad = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $logo = null;

    #[ORM\OneToOne(inversedBy: 'id_user_protectora', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $id_user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getCapacidad(): ?int
    {
        return $this->capacidad;
    }

    public function setCapacidad(?int $capacidad): self
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function setLogo($logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getIdUser(): ?Usuario
    {
        return $this->id_user;
    }

    public function setIdUser(Usuario $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }
}
