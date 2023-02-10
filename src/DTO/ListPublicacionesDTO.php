<?php

namespace App\DTO;

use Doctrine\Common\Collections\Collection;

class ListPublicacionesDTO{

    private int $id;
    private string $cuerpo;
    private string $fecha_pu;
    private int $likes;
    private string $imagen;

    private string $username;

    private string $comentario;

    private string $comentarioUsername;


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
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getComentario(): string
    {
        return $this->comentario;
    }

    /**
     * @param string $comentario
     */
    public function setComentario(string $comentario): void
    {
        $this->comentario = $comentario;
    }



    /**
     * @return string
     */
    public function getComentarioUsername(): string
    {
        return $this->comentarioUsername;
    }

    /**
     * @param string $comentarioUsername
     */
    public function setComentarioUsername(string $comentarioUsername): void
    {
        $this->comentarioUsername = $comentarioUsername;
    }



}