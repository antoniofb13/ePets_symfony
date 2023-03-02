<?php

namespace App\DTO;

class saveLikeDTO
{
    private string $idPub;

    /**
     * @return string
     */
    public function getIdPub(): string
    {
        return $this->idPub;
    }

    /**
     * @param string $idPub
     */
    public function setIdPub(string $idPub): void
    {
        $this->idPub = $idPub;
    }


}