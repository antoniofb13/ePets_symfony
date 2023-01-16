<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
class Usuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 9)]
    private ?string $telefono = null;

    #[ORM\ManyToOne(inversedBy: 'id_rol')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Rol $id_rol = null;

    #[ORM\OneToMany(mappedBy: 'id_user', targetEntity: Publicaciones::class, orphanRemoval: true)]
    private Collection $id_user;

    #[ORM\OneToMany(mappedBy: 'id_user', targetEntity: Comentarios::class, orphanRemoval: true)]
    private Collection $id_user_coment;

    #[ORM\OneToOne(mappedBy: 'id_user', cascade: ['persist', 'remove'])]
    private ?DatosProtectora $id_user_protectora = null;

    #[ORM\OneToOne(mappedBy: 'id_emisor', cascade: ['persist', 'remove'])]
    private ?Chat $id_usuario_emisor = null;

    #[ORM\OneToOne(mappedBy: 'id_receptor', cascade: ['persist', 'remove'])]
    private ?Chat $id_usuario_receptor = null;

    #[ORM\OneToMany(mappedBy: 'id_user', targetEntity: Adopcion::class, orphanRemoval: true)]
    private Collection $id_usuario_adopcion;

    public function __construct()
    {
        $this->id_user = new ArrayCollection();
        $this->id_user_coment = new ArrayCollection();
        $this->id_usuario_adopcion = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

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

    /**
     * @return Collection<int, Publicaciones>
     */
    public function getIdUser(): Collection
    {
        return $this->id_user;
    }

    public function addIdUser(Publicaciones $idUser): self
    {
        if (!$this->id_user->contains($idUser)) {
            $this->id_user->add($idUser);
            $idUser->setIdUser($this);
        }

        return $this;
    }

    public function removeIdUser(Publicaciones $idUser): self
    {
        if ($this->id_user->removeElement($idUser)) {
            // set the owning side to null (unless already changed)
            if ($idUser->getIdUser() === $this) {
                $idUser->setIdUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comentarios>
     */
    public function getIdUserComent(): Collection
    {
        return $this->id_user_coment;
    }

    public function addIdUserComent(Comentarios $idUserComent): self
    {
        if (!$this->id_user_coment->contains($idUserComent)) {
            $this->id_user_coment->add($idUserComent);
            $idUserComent->setIdUser($this);
        }

        return $this;
    }

    public function removeIdUserComent(Comentarios $idUserComent): self
    {
        if ($this->id_user_coment->removeElement($idUserComent)) {
            // set the owning side to null (unless already changed)
            if ($idUserComent->getIdUser() === $this) {
                $idUserComent->setIdUser(null);
            }
        }

        return $this;
    }

    public function getIdUserProtectora(): ?DatosProtectora
    {
        return $this->id_user_protectora;
    }

    public function setIdUserProtectora(DatosProtectora $id_user_protectora): self
    {
        // set the owning side of the relation if necessary
        if ($id_user_protectora->getIdUser() !== $this) {
            $id_user_protectora->setIdUser($this);
        }

        $this->id_user_protectora = $id_user_protectora;

        return $this;
    }

    public function getIdUsuarioEmisor(): ?Chat
    {
        return $this->id_usuario_emisor;
    }

    public function setIdUsuarioEmisor(Chat $id_usuario_emisor): self
    {
        // set the owning side of the relation if necessary
        if ($id_usuario_emisor->getIdEmisor() !== $this) {
            $id_usuario_emisor->setIdEmisor($this);
        }

        $this->id_usuario_emisor = $id_usuario_emisor;

        return $this;
    }

    public function getIdUsuarioReceptor(): ?Chat
    {
        return $this->id_usuario_receptor;
    }

    public function setIdUsuarioReceptor(Chat $id_usuario_receptor): self
    {
        // set the owning side of the relation if necessary
        if ($id_usuario_receptor->getIdReceptor() !== $this) {
            $id_usuario_receptor->setIdReceptor($this);
        }

        $this->id_usuario_receptor = $id_usuario_receptor;

        return $this;
    }

    /**
     * @return Collection<int, Adopcion>
     */
    public function getIdUsuarioAdopcion(): Collection
    {
        return $this->id_usuario_adopcion;
    }

    public function addIdUsuarioAdopcion(Adopcion $idUsuarioAdopcion): self
    {
        if (!$this->id_usuario_adopcion->contains($idUsuarioAdopcion)) {
            $this->id_usuario_adopcion->add($idUsuarioAdopcion);
            $idUsuarioAdopcion->setIdUser($this);
        }

        return $this;
    }

    public function removeIdUsuarioAdopcion(Adopcion $idUsuarioAdopcion): self
    {
        if ($this->id_usuario_adopcion->removeElement($idUsuarioAdopcion)) {
            // set the owning side to null (unless already changed)
            if ($idUsuarioAdopcion->getIdUser() === $this) {
                $idUsuarioAdopcion->setIdUser(null);
            }
        }

        return $this;
    }
}
