<?php

namespace App\Entity;

use App\Repository\ChatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChatRepository::class)]
class Chat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cuerpo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_mensaje = null;

    #[ORM\OneToOne(inversedBy: 'id_usuario_emisor', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $id_emisor = null;

    #[ORM\OneToOne(inversedBy: 'id_usuario_receptor', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $id_receptor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCuerpo(): ?string
    {
        return $this->cuerpo;
    }

    public function setCuerpo(?string $cuerpo): self
    {
        $this->cuerpo = $cuerpo;

        return $this;
    }

    public function getFechaMensaje(): ?\DateTimeInterface
    {
        return $this->fecha_mensaje;
    }

    public function setFechaMensaje(\DateTimeInterface $fecha_mensaje): self
    {
        $this->fecha_mensaje = $fecha_mensaje;

        return $this;
    }

    public function getIdEmisor(): ?Usuario
    {
        return $this->id_emisor;
    }

    public function setIdEmisor(Usuario $id_emisor): self
    {
        $this->id_emisor = $id_emisor;

        return $this;
    }

    public function getIdReceptor(): ?Usuario
    {
        return $this->id_receptor;
    }

    public function setIdReceptor(Usuario $id_receptor): self
    {
        $this->id_receptor = $id_receptor;

        return $this;
    }
}
