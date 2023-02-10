<?php

namespace App\DTO;

use phpDocumentor\Reflection\Types\Collection;
use Symfony\Component\Serializer\Annotation\Ignore;

class ComentarioListarDTO{

    private int $id;
    private string $mensaje;

    private string $fechaCom;

    private string $username;


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
    public function getMensaje(): string
    {
        return $this->mensaje;
    }

    /**
     * @param string $mensaje
     */
    public function setMensaje(string $mensaje): void
    {
        $this->mensaje = $mensaje;
    }

    /**
     * @return string
     */
    public function getFechaCom(): string
    {
        return $this->fechaCom;
    }

    /**
     * @param string $fechaCom
     */
    public function setFechaCom(string $fechaCom): void
    {
        $this->fechaCom = $fechaCom;
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
