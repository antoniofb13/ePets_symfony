<?php

namespace App\DTO;

class PublicacionSaveDTO
{
    private string $username;
    private string $cuerpo;


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


}