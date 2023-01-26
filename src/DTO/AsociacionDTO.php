<?php

namespace App\DTO;

use App\Entity\User;

class AsociacionDTO{
    private int $id;
    private string $direccion;
    private int $capacidad;
    private User $user;

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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }


}