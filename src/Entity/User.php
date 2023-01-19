<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $username = null;

    #[ORM\Column(length: 50)]
    private ?string $nombre = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $apellidos = null;

    #[ORM\Column(length: 200)]
    private ?string $email = null;

    #[ORM\Column(length: 9)]
    private ?string $telefono = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private $imagen = null;

    #[ORM\Column]
    private ?bool $protectora = null;

    #[ORM\ManyToOne(inversedBy: 'id_user')]
    #[ORM\JoinColumn(nullable: false)]
    private ?rol $id_rol = null;

    #[ORM\OneToMany(mappedBy: 'id_user', targetEntity: Publicaciones::class, orphanRemoval: true)]
    private Collection $publicaciones;

    #[ORM\OneToMany(mappedBy: 'id_user', targetEntity: Comentarios::class, orphanRemoval: true)]
    private Collection $comentarios;

    #[ORM\OneToOne(mappedBy: 'id_user', cascade: ['persist', 'remove'])]
    private ?DatosProtectora $datosProtectora = null;

    #[ORM\OneToMany(mappedBy: 'id_emisor', targetEntity: Chat::class, orphanRemoval: true)]
    private Collection $chats;

    #[ORM\OneToMany(mappedBy: 'id_receptor', targetEntity: Chat::class, orphanRemoval: true)]
    private Collection $chatsReceptor;

    #[ORM\OneToMany(mappedBy: 'id_user', targetEntity: Adopcion::class, orphanRemoval: true)]
    private Collection $adopcions;

    public function __construct()
    {
        $this->publicaciones = new ArrayCollection();
        $this->comentarios = new ArrayCollection();
        $this->chats = new ArrayCollection();
        $this->chatsReceptor = new ArrayCollection();
        $this->adopcions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(?string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen( string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function isProtectora(): ?bool
    {
        return $this->protectora;
    }

    public function setProtectora(bool $protectora): self
    {
        $this->protectora = $protectora;

        return $this;
    }

    public function getIdRol(): ?rol
    {
        return $this->id_rol;
    }

    public function setIdRol(?rol $id_rol): self
    {
        $this->id_rol = $id_rol;

        return $this;
    }

    /**
     * @return Collection<int, Publicaciones>
     */
    public function getPublicaciones(): Collection
    {
        return $this->publicaciones;
    }

    public function addPublicaciones(Publicaciones $publicaciones): self
    {
        if (!$this->publicaciones->contains($publicaciones)) {
            $this->publicaciones->add($publicaciones);
            $publicaciones->setIdUser($this);
        }

        return $this;
    }

    public function removePublicaciones(Publicaciones $publicaciones): self
    {
        if ($this->publicaciones->removeElement($publicaciones)) {
            // set the owning side to null (unless already changed)
            if ($publicaciones->getIdUser() === $this) {
                $publicaciones->setIdUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comentarios>
     */
    public function getComentarios(): Collection
    {
        return $this->comentarios;
    }

    public function addComentario(Comentarios $comentario): self
    {
        if (!$this->comentarios->contains($comentario)) {
            $this->comentarios->add($comentario);
            $comentario->setIdUser($this);
        }

        return $this;
    }

    public function removeComentario(Comentarios $comentario): self
    {
        if ($this->comentarios->removeElement($comentario)) {
            // set the owning side to null (unless already changed)
            if ($comentario->getIdUser() === $this) {
                $comentario->setIdUser(null);
            }
        }

        return $this;
    }

    public function getDatosProtectora(): ?DatosProtectora
    {
        return $this->datosProtectora;
    }

    public function setDatosProtectora(DatosProtectora $datosProtectora): self
    {
        // set the owning side of the relation if necessary
        if ($datosProtectora->getIdUser() !== $this) {
            $datosProtectora->setIdUser($this);
        }

        $this->datosProtectora = $datosProtectora;

        return $this;
    }

    /**
     * @return Collection<int, Chat>
     */
    public function getChats(): Collection
    {
        return $this->chats;
    }

    public function addChat(Chat $chat): self
    {
        if (!$this->chats->contains($chat)) {
            $this->chats->add($chat);
            $chat->setIdEmisor($this);
        }

        return $this;
    }

    public function removeChat(Chat $chat): self
    {
        if ($this->chats->removeElement($chat)) {
            // set the owning side to null (unless already changed)
            if ($chat->getIdEmisor() === $this) {
                $chat->setIdEmisor(null);
            }
        }

        return $this;
    }/**
     * @return Collection<int, Chat>
     */
    public function getChatReceptor(): Collection
    {
        return $this->chatsReceptor;
    }

    public function addChatReceptor(Chat $chat): self
    {
        if (!$this->chats->contains($chat)) {
            $this->chats->add($chat);
            $chat->setIdReceptor($this);
        }

        return $this;
    }

    public function removeChatReceptor(Chat $chat): self
    {
        if ($this->chats->removeElement($chat)) {
            // set the owning side to null (unless already changed)
            if ($chat->getIdReceptor() === $this) {
                $chat->setIdReceptor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Adopcion>
     */
    public function getAdopcions(): Collection
    {
        return $this->adopcions;
    }

    public function addAdopcion(Adopcion $adopcion): self
    {
        if (!$this->adopcions->contains($adopcion)) {
            $this->adopcions->add($adopcion);
            $adopcion->setIdUser($this);
        }

        return $this;
    }

    public function removeAdopcion(Adopcion $adopcion): self
    {
        if ($this->adopcions->removeElement($adopcion)) {
            // set the owning side to null (unless already changed)
            if ($adopcion->getIdUser() === $this) {
                $adopcion->setIdUser(null);
            }
        }

        return $this;
    }
}
