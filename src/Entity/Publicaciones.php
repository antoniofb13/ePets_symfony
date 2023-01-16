<?php

namespace App\Entity;

use App\Repository\PublicacionesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PublicacionesRepository::class)]
class Publicaciones
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $imagen = null;

    #[ORM\Column(length: 255)]
    private ?string $cuerpo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_pub = null;

    #[ORM\Column(nullable: true)]
    private ?int $likes = null;

    #[ORM\ManyToOne(inversedBy: 'id_user')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $id_user = null;

    #[ORM\OneToMany(mappedBy: 'id_pub', targetEntity: Comentarios::class, orphanRemoval: true)]
    private Collection $id_pub;

    public function __construct()
    {
        $this->id_pub = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function setImagen($imagen): self
    {
        $this->imagen = $imagen;

        return $this;
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

    public function getFechaPub(): ?\DateTimeInterface
    {
        return $this->fecha_pub;
    }

    public function setFechaPub(\DateTimeInterface $fecha_pub): self
    {
        $this->fecha_pub = $fecha_pub;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(?int $likes): self
    {
        $this->likes = $likes;

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

    /**
     * @return Collection<int, Comentarios>
     */
    public function getIdPub(): Collection
    {
        return $this->id_pub;
    }

    public function addIdPub(Comentarios $idPub): self
    {
        if (!$this->id_pub->contains($idPub)) {
            $this->id_pub->add($idPub);
            $idPub->setIdPub($this);
        }

        return $this;
    }

    public function removeIdPub(Comentarios $idPub): self
    {
        if ($this->id_pub->removeElement($idPub)) {
            // set the owning side to null (unless already changed)
            if ($idPub->getIdPub() === $this) {
                $idPub->setIdPub(null);
            }
        }

        return $this;
    }
}
