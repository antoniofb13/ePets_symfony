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

    #[ORM\Column(length: 255)]
    private ?string $cuerpo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_mensaje = null;

    #[ORM\ManyToOne(inversedBy: 'chats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $id_emisor = null;

    #[ORM\ManyToOne(inversedBy: 'chatsReceptor')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $id_receptor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCuerpo(): ?string
    {
        return $this->cuerpo;
    }

    public function setCuerpo(string $cuerpo): self
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

    public function getIdEmisor(): ?user
    {
        return $this->id_emisor;
    }

    public function setIdEmisor(?user $id_emisor): self
    {
        $this->id_emisor = $id_emisor;

        return $this;
    }

    public function getIdReceptor(): ?user
    {
        return $this->id_receptor;
    }

    public function setIdReceptor(?user $id_receptor): self
    {
        $this->id_receptor = $id_receptor;

        return $this;
    }
}
