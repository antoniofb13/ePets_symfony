<?php

namespace App\DTO;

use App\Entity\Publicaciones;
use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Ignore;

class ComentariosDTO{

    #[Ignore]
    private int $id;

    private string $mensaje;

    #[Ignore]
    private string $fechaCom;

    //private int $id_publicacion;

    #[Ignore]
    private UserDto $user;

    #[Ignore]
    private PublicacionesDTO $publicacion;

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

   // /**
   //  * @return int
   //  */
   // public function getIdPublicacion(): int
   // {
   //     return $this->id_publicacion;
   // }
//
   // /**
   //  * @param int $id_publicacion
   //  */
   // public function setIdPublicacion(int $id_publicacion): void
   // {
   //     $this->id_publicacion = $id_publicacion;
   // }

    /**
     * @return UserDto
     */
    public function getUser(): UserDto
    {
        return $this->user;
    }

    /**
     * @param UserDto $user
     */
    public function setUser(UserDto $user): void
    {
        $this->user = $user;
    }

    /**
     * @return PublicacionesDTO
     */
    public function getPublicacion(): PublicacionesDTO
    {
        return $this->publicacion;
    }

    /**
     * @param PublicacionesDTO $publicacion
     */
    public function setPublicacion(PublicacionesDTO $publicacion): void
    {
        $this->publicacion = $publicacion;
    }

}
