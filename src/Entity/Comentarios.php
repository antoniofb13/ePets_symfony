<?php

namespace App\Entity;

use App\Repository\ComentariosRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComentariosRepository::class)]
class Comentarios
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $mensaje = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_com = null;

    #[ORM\ManyToOne(inversedBy: 'id_pub')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Publicaciones $id_pub = null;

    #[ORM\ManyToOne(inversedBy: 'id_user_coment')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $id_user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMensaje(): ?string
    {
        return $this->mensaje;
    }

    public function setMensaje(string $mensaje): self
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    public function getFechaCom(): ?\DateTimeInterface
    {
        return $this->fecha_com;
    }

    public function setFechaCom(\DateTimeInterface $fecha_com): self
    {
        $this->fecha_com = $fecha_com;

        return $this;
    }

    public function getIdPub(): ?Publicaciones
    {
        return $this->id_pub;
    }

    public function setIdPub(?Publicaciones $id_pub): self
    {
        $this->id_pub = $id_pub;

        return $this;
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
}
