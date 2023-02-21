<?php

namespace App\DTO;

use Doctrine\Common\Collections\Collection;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Serializer\Annotation\Ignore;

class PublicacionesDTO
{
    private int $id;
    private string $cuerpo;
    private string $fecha_pu;
    private int $likes;
    private string $imagen;

    private UserDto $user;

    private Collection $tags;

    private Collection $comentarios;

    private ?bool $estado;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCuerpo(): string
    {
        return $this->cuerpo;
    }

    /**
     * @param string $cuerpo
     */
    public function setCuerpo(string $cuerpo): void
    {
        $this->cuerpo = $cuerpo;
    }

    /**
     * @return string
     */
    public function getFechaPu(): string
    {
        return $this->fecha_pu;
    }

    /**
     * @param string $fecha_pu
     */
    public function setFechaPu(string $fecha_pu): void
    {
        $this->fecha_pu = $fecha_pu;
    }



    /**
     * @return int
     */
    public function getLikes(): int
    {
        return $this->likes;
    }

    /**
     * @param int $likes
     */
    public function setLikes(int $likes): void
    {
        $this->likes = $likes;
    }

    /**
     * @return string
     */
    public function getImagen(): string
    {
        return $this->imagen;
    }

    /**
     * @param string $imagen
     */
    public function setImagen(string $imagen): void
    {
        $this->imagen = $imagen;
    }

    /**
     * @return UserDto
     */
    public function getUser(): UserDto
    {
        return $this->user;
    }

    /**
     * @param UserDto $user
     */
    public function setUser(UserDto $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Collection
     */
    public function getComentarios(): Collection
    {
        return $this->comentarios;
    }

    /**
     * @param Collection $comentarios
     */
    public function setComentarios(Collection $comentarios): void
    {
        $this->comentarios = $comentarios;
    }



    /**
     * @return bool|null
     */
    public function getEstado(): ?bool
    {
        return $this->estado;
    }

    /**
     * @param bool|null $estado
     */
    public function setEstado(?bool $estado): void
    {
        $this->estado = $estado;
    }

    /**
     * @return Collection
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * @param Collection $tags
     */
    public function setTags(Collection $tags): void
    {
        $this->tags = $tags;
    }




}