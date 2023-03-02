<?php

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\Ignore;

class SaveChatDTO
{
    private string $cuerpo;
    private int $id_receptor;


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
     * @return int
     */
    public function getIdReceptor(): int
    {
        return $this->id_receptor;
    }

    /**
     * @param int $id_receptor
     */
    public function setIdReceptor(int $id_receptor): void
    {
        $this->id_receptor = $id_receptor;
    }



}