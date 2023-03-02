<?php

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\Ignore;

class ChatDTO
{
    private int $id;

    private string $cuerpo;

    private string $fecha;

    private UserDto $emisor;

    private UserDto $receptor;

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
    public function getFecha(): string
    {
        return $this->fecha;
    }

    /**
     * @param string $fecha
     */
    public function setFecha(string $fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * @return UserDto
     */
    public function getEmisor(): UserDto
    {
        return $this->emisor;
    }

    /**
     * @param UserDto $emisor
     */
    public function setEmisor(UserDto $emisor): void
    {
        $this->emisor = $emisor;
    }

    /**
     * @return UserDto
     */
    public function getReceptor(): UserDto
    {
        return $this->receptor;
    }

    /**
     * @param UserDto $receptor
     */
    public function setReceptor(UserDto $receptor): void
    {
        $this->receptor = $receptor;
    }



}