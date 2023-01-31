<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
    private ?string $imagen = null;

    #[ORM\Column]
    private ?bool $protectora = null;

    #[ORM\ManyToOne(inversedBy: 'id_user')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Rol $id_rol = null;

    #[ORM\OneToMany(mappedBy: 'id_usuario', targetEntity: ApiKey::class, orphanRemoval: true)]
    private Collection $apiKeys;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Publicaciones::class, orphanRemoval: true)]
    private Collection $publicaciones;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Asociaciones $asociaciones = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Comentarios::class, orphanRemoval: true)]
    private Collection $comentarios;

    #[ORM\OneToMany(mappedBy: 'emisor', targetEntity: Chat::class, orphanRemoval: true)]
    private Collection $chat_emisor;

    #[ORM\OneToMany(mappedBy: 'receptor', targetEntity: Chat::class, orphanRemoval: true)]
    private Collection $chat_receptor;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Adopcion::class, orphanRemoval: true)]
    private Collection $adopciones;




    public function __construct()
    {
        $this->apiKeys = new ArrayCollection();
        $this->publicaciones = new ArrayCollection();
        $this->comentarios = new ArrayCollection();
        $this->chat_emisor = new ArrayCollection();
        $this->chat_receptor = new ArrayCollection();
        $this->adopciones = new ArrayCollection();
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

    public function setImagen(string $imagen): self
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

    public function getIdRol(): ?Rol
    {
        return $this->id_rol;
    }

    public function setIdRol(?Rol $id_rol): self
    {
        $this->id_rol = $id_rol;

        return $this;
    }


    public function toString(): array
    {
        return [
            'username' => $this->username,
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'correo' => $this->email,
            'password' => $this->password,
            'telefono' => $this->telefono,
            'protectora' => $this->protectora,
            'rol' => $this->id_rol->getTipo()
        ];
    }

    /**
     * @return Collection<int, ApiKey>
     */
    public function getApiKeys(): Collection
    {
        return $this->apiKeys;
    }

    public function addApiKey(ApiKey $apiKey): self
    {
        if (!$this->apiKeys->contains($apiKey)) {
            $this->apiKeys->add($apiKey);
            $apiKey->setIdUsuario($this);
        }

        return $this;
    }

    public function removeApiKey(ApiKey $apiKey): self
    {
        if ($this->apiKeys->removeElement($apiKey)) {
            // set the owning side to null (unless already changed)
            if ($apiKey->getIdUsuario() === $this) {
                $apiKey->setIdUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Publicaciones>
     */
    public function getPublicaciones(): Collection
    {
        return $this->publicaciones;
    }

    public function addPublicacione(Publicaciones $publicacione): self
    {
        if (!$this->publicaciones->contains($publicacione)) {
            $this->publicaciones->add($publicacione);
            $publicacione->setUser($this);
        }

        return $this;
    }

    public function removePublicacione(Publicaciones $publicacione): self
    {
        if ($this->publicaciones->removeElement($publicacione)) {
            // set the owning side to null (unless already changed)
            if ($publicacione->getUser() === $this) {
                $publicacione->setUser(null);
            }
        }

        return $this;
    }

    public function getAsociaciones(): ?Asociaciones
    {
        return $this->asociaciones;
    }

    public function setAsociaciones(Asociaciones $asociaciones): self
    {
        // set the owning side of the relation if necessary
        if ($asociaciones->getUser() !== $this) {
            $asociaciones->setUser($this);
        }

        $this->asociaciones = $asociaciones;

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
            $comentario->setUser($this);
        }

        return $this;
    }

    public function removeComentario(Comentarios $comentario): self
    {
        if ($this->comentarios->removeElement($comentario)) {
            // set the owning side to null (unless already changed)
            if ($comentario->getUser() === $this) {
                $comentario->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Chat>
     */
    public function getChatEmisor(): Collection
    {
        return $this->chat_emisor;
    }

    public function addChatEmisor(Chat $chatEmisor): self
    {
        if (!$this->chat_emisor->contains($chatEmisor)) {
            $this->chat_emisor->add($chatEmisor);
            $chatEmisor->setEmisor($this);
        }

        return $this;
    }

    public function removeChatEmisor(Chat $chatEmisor): self
    {
        if ($this->chat_emisor->removeElement($chatEmisor)) {
            // set the owning side to null (unless already changed)
            if ($chatEmisor->getEmisor() === $this) {
                $chatEmisor->setEmisor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Chat>
     */
    public function getChatReceptor(): Collection
    {
        return $this->chat_receptor;
    }

    public function addChatReceptor(Chat $chatReceptor): self
    {
        if (!$this->chat_receptor->contains($chatReceptor)) {
            $this->chat_receptor->add($chatReceptor);
            $chatReceptor->setReceptor($this);
        }

        return $this;
    }

    public function removeChatReceptor(Chat $chatReceptor): self
    {
        if ($this->chat_receptor->removeElement($chatReceptor)) {
            // set the owning side to null (unless already changed)
            if ($chatReceptor->getReceptor() === $this) {
                $chatReceptor->setReceptor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Adopcion>
     */
    public function getAdopciones(): Collection
    {
        return $this->adopciones;
    }

    public function addAdopcione(Adopcion $adopcione): self
    {
        if (!$this->adopciones->contains($adopcione)) {
            $this->adopciones->add($adopcione);
            $adopcione->setUser($this);
        }

        return $this;
    }

    public function removeAdopcione(Adopcion $adopcione): self
    {
        if ($this->adopciones->removeElement($adopcione)) {
            // set the owning side to null (unless already changed)
            if ($adopcione->getUser() === $this) {
                $adopcione->setUser(null);
            }
        }

        return $this;
    }
}
