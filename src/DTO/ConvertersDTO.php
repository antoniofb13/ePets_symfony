<?php

namespace App\DTO;

use App\Entity\Asociaciones;
use App\Entity\Comentarios;
use App\Entity\Publicaciones;
use App\Entity\User;
use Doctrine\Common\Collections\Collection;

class ConvertersDTO
{

    /**
     * @param User $user
     */
    public function userToDTO(User $user): UserDto
    {
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
    public function asociacionToDTO(Asociaciones $asociacion): AsociacionDTO
    {
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
    public function publicacionDTO(Publicaciones $publicacion): PublicacionesDTO
    {
        $publicacionDTO = new PublicacionesDTO();
        $publicacionDTO->setId($publicacion->getId());
        $publicacionDTO->setUser($this->userToDTO($publicacion->getUser()));
        $publicacionDTO->setCuerpo($publicacion->getCuerpo());
        $publicacionDTO->setFechaPu($publicacion->getFechaPub()->format("d/m/Y H:i"));
        $publicacionDTO->setLikes($publicacion->getLikes());
        $publicacionDTO->setEstado($publicacion->isEstado());
        //if ($publicacion->getComentarios() != null) {
        //    $publicacionDTO->setComentarios($this->comentariosListToDTO($publicacion->getComentarios()));
        //}
        //$publicacion->setImagen($publicacion->getImagen());
        return $publicacionDTO;
    }

    /**
     * @param Publicaciones $publicacion
     */
    public function publicacionListDTO(Publicaciones $publicacion, Comentarios $comentarios): ListPublicacionesDTO
    {
        $listPublicacionDTO = new ListPublicacionesDTO();
        $listPublicacionDTO->setId($publicacion->getId());
        $listPublicacionDTO->setUsername($publicacion->getUser()->getUsername());
        $listPublicacionDTO->setCuerpo($publicacion->getCuerpo());
        $listPublicacionDTO->setFechaPu($publicacion->getFechaPub()->format("d/m/Y H:i"));
        $listPublicacionDTO->setLikes($publicacion->getLikes());
        $listPublicacionDTO->setComentario($comentarios->getMensaje());
        $listPublicacionDTO->setComentarioUsername($comentarios->getUser()->getUsername());
        //$publicacion->setImagen($publicacion->getImagen());
        return $listPublicacionDTO;
    }

    /**
     * @param Publicaciones $publicacion
     */
    public function publicacionListNoComentDTO(Publicaciones $publicacion): ListPublicacionesDTO
    {
        $listPublicacionDTO = new ListPublicacionesDTO();
        $listPublicacionDTO->setId($publicacion->getId());
        $listPublicacionDTO->setUsername($publicacion->getUser()->getUsername());
        $listPublicacionDTO->setCuerpo($publicacion->getCuerpo());
        $listPublicacionDTO->setFechaPu($publicacion->getFechaPub()->format("d/m/Y H:i"));
        $listPublicacionDTO->setLikes($publicacion->getLikes());
        //$publicacion->setImagen($publicacion->getImagen());
        return $listPublicacionDTO;
    }

    /**
     * @param Comentarios $comentarios
     */
    public function comentariosDTO(Comentarios $comentarios): array
    {
        $comentariosDTO = new ComentariosDTO();
        $comentariosDTO->setId($comentarios->getId());
        $comentariosDTO->setMensaje($comentarios->getMensaje());
        $comentariosDTO->setFechaCom($comentarios->getFechaCom()->format("d/m/Y H:i"));
        $comentariosDTO->setUser($this->userToDTO($comentarios->getUser()));
        $comentariosDTO->setPublicacion($this->publicacionDTO($comentarios->getPublicacion()));

        $lista = (array) $comentariosDTO;
        var_dump($lista);
        $lista = get_object_vars($comentariosDTO);
        var_dump($lista);

        return $lista;
    }

    /**
     * @param Comentarios $comentarios
     */
    public function comentariosListToDTO(Comentarios $comentarios): ComentarioListarDTO
    {
        $comentarioList = new ComentarioListarDTO();
        $comentarioList->setId($comentarios->getId());
        $comentarioList->setUsername($comentarios->getUser()->getUsername());
        $comentarioList->setMensaje($comentarios->getMensaje());
        $comentarioList->setFechaCom($comentarios->getFechaCom()->format("d/m/Y H:i"));
        return $comentarioList;
    }

}
