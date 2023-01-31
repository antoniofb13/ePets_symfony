<?php

namespace App\DTO;

use App\Entity\Asociaciones;
use App\Entity\Publicaciones;
use App\Entity\User;

class ConvertersDTO{

   /**
    * @param User $user
    */
    public function userToDTO(User $user):UserDto{
        $usuarioDTO = new UserDto();
        $usuarioDTO->setId($user->getId());
        $usuarioDTO->setEmail($user->getEmail());
        $usuarioDTO->setUsername($user->getUsername());
        $usuarioDTO->setNombre($user->getNombre());
        $usuarioDTO->setApellidos($user->getApellidos());
        $usuarioDTO->setTelefono($user->getTelefono());
        $usuarioDTO->setRol($user->getIdRol()->getTipo());
        $usuarioDTO->setProtectora($user->isProtectora());
        return $usuarioDTO;
    }

    /**
     * @param Asociaciones $asociacion
     */
    public function asociacionToDTO(Asociaciones $asociacion):AsociacionDTO{
        $asociacionDTO = new AsociacionDTO();
        $asociacionDTO->setId($asociacion->getId());
        $asociacionDTO->setUserDto($this->userToDTO($asociacion->getUser()));
        $asociacionDTO->setDireccion($asociacion->getDireccion());
        $asociacionDTO->setCapacidad($asociacion->getCapacidad());
        return $asociacionDTO;
    }

    /**
     * @param Publicaciones $publicacion
     */
    public function publicacionDTO(Publicaciones $publicacion):PublicacionesDTO{
        $publicacionDTO = new PublicacionesDTO();
        $publicacionDTO->setId($publicacion->getId());
        $publicacionDTO->setUser($this->userToDTO($publicacion->getUser()));
        $publicacionDTO->setCuerpo($publicacion->getCuerpo());
        $publicacionDTO->setFechaPu($publicacion->getFechaPub()->format("d/m/Y H:i"));
        $publicacionDTO->setLikes($publicacion->getLikes());
        $publicacion->setImagen($publicacion->getImagen());
        return $publicacionDTO;
    }
}
