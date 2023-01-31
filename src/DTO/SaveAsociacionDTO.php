<?php

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\Ignore;

class SaveAsociacionDTO{
    #[Ignore]
    private int $id;
    private string $direccion;
    private int $capacidad;

    private string $username;

    public function __construct()
    {
    }

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
    public function getDireccion(): string
    {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     */
    public function setDireccion(string $direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return int
     */
    public function getCapacidad(): int
    {
        return $this->capacidad;
    }

    /**
     * @param int $capacidad
     */
    public function setCapacidad(int $capacidad): void
    {
        $this->capacidad = $capacidad;
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


}

