<?php

namespace App\DTO;

class CambiarEstadoPubDTO
{
    private ?bool $estado;

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


}