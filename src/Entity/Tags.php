<?php

namespace App\Entity;

use App\Repository\TagsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagsRepository::class)]
class Tags
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\ManyToMany(targetEntity: Publicaciones::class, inversedBy: 'tags')]
    private Collection $publicacion;

    public function __construct()
    {
        $this->publicacion = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Publicaciones>
     */
    public function getPublicacion(): Collection
    {
        return $this->publicacion;
    }

    public function addPublicacion(Publicaciones $publicacion): self
    {
        if (!$this->publicacion->contains($publicacion)) {
            $this->publicacion->add($publicacion);
        }

        return $this;
    }

    public function removePublicacion(Publicaciones $publicacion): self
    {
        $this->publicacion->removeElement($publicacion);

        return $this;
    }
}
