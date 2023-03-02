<?php

namespace App\DTO;

use App\Entity\Asociaciones;
use App\Entity\Comentarios;
use App\Entity\Publicaciones;
use App\Entity\Tags;
use App\Entity\User;
use App\Utilities\Utilidades;
use Doctrine\Common\Collections\ArrayCollection;
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
        $usuarioDTO->setImagen($user->getImagen());
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
        $asociacionDTO->setLogo($asociacion->getLogo());
        return $asociacionDTO;
    }

    /**
     * @param Publicaciones $publicacion
     */
    public function publicacionDTO(Publicaciones $publicacion): PublicacionesDTO
    {
        $utilidades = new Utilidades();
        $publicacionDTO = new PublicacionesDTO();
        $publicacionDTO->setId($publicacion->getId());
        $publicacionDTO->setUser($this->userToDTO($publicacion->getUser()));
        $publicacionDTO->setCuerpo($publicacion->getCuerpo());
        $publicacionDTO->setFechaPu($publicacion->getFechaPub()->format("d/m/Y H:i"));
        $publicacionDTO->setLikes($publicacion->getLikes());
        $publicacionDTO->setEstado($publicacion->isEstado());
        if ($publicacion->getImagen()!=null){
            $publicacionDTO->setImagen($publicacion->getImagen());
        }


        $tags = new ArrayCollection();
        foreach ($publicacion->getTags() as $tag){
            $tagDTO = new TagsDTO();
            $tagDTO->setId($tag->getId());
            $tagDTO->setNombre($tag->getNombre());
            $tags[] = $tagDTO;
        }
        $publicacionDTO->setTags($tags);

        $comentarios = new ArrayCollection();
        foreach ($publicacion->getComentarios() as $comen){
            $comentarioDTO = new ComentariosDTO();
            $comentarioDTO->setId($comen->getId());
            $comentarioDTO-> setUser($this->userToDTO($comen->getUser()));
            $comentarioDTO->setMensaje($comen->getMensaje());
            $comentarioDTO->setFechaCom($comen->getFechaCom()->format("d/m/Y H:i"));
            $comentarios[] = $comentarioDTO;
        }
        $publicacionDTO->setComentarios($comentarios);

        return $publicacionDTO;
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
     * @param Tags $tags
     */
    public function tagsToDTO(Tags $tags): TagsDTO
    {
        $tagDTO = new TagsDTO();
        $tagDTO->setId($tags->getId());
        $tagDTO->setNombre($tags->getNombre());
        return $tagDTO;
    }
}
