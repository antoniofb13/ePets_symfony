<?php

namespace App\Utilities;

use App\Entity\ApiKey;
use App\Entity\User;
use App\Repository\ApiKeyRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use ReallySimpleJWT\Token;



class Utilidades
{


    public function toJson($data):string
    {
        //Inicialización de serializador
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        //Conversion a JSON
        return $serializer->serialize($data, 'json');

    }

    public function hashPassword($password):string
    {

        $factory = new PasswordHasherFactory([
            'common' => ['algorithm' => 'bcrypt'],
            'memory-hard' => ['algorithm' => 'sodium'],
        ]);

        $passwordHasher = $factory->getPasswordHasher('common');

        return $passwordHasher->hash($password);

    }

    public function  verify($passwordPlain, $passwordBD):bool
    {
        $factory = new PasswordHasherFactory([
            'common' => ['algorithm' => 'bcrypt'],
            'memory-hard' => ['algorithm' => 'sodium'],
        ]);

        $passwordHasher = $factory->getPasswordHasher('common');

        return $passwordHasher->verify($passwordBD,$passwordPlain);

    }

    public function  generateApiToken(User $user, ApiKeyRepository $apiKeyRepository):string
    {

        //GENERO UN OBJETO CON API KEY NUEVO
        $apiKey = new ApiKey();
        $apiKey->setIdUsuario($user);
        $fechaActual5hour = date("Y-m-d H:i:s", strtotime('+5 hours'));
        $fechaExpiracion = DateTime::createFromFormat('Y-m-d H:i:s', $fechaActual5hour);
        $apiKey->setFechaExpiracion($fechaExpiracion);

        $tokenData = [
            'user_id' => $user->getId(),
            'username' => $user->getUsername(),
            'user_rol' => $user->getIdRol()->getTipo(),
            'fecha_expiracion' => $fechaExpiracion,
        ];

        $secret = $user->getPassword();

        $token = Token::customPayload($tokenData, $secret);

        $apiKey->setToken($token);

        $apiKeyRepository->save($apiKey,true);


        return $token;
    }

    public function esApiKeyValida($token, $permisoRequerido, ApiKeyRepository $apiKeyRepository,UserRepository $usuarioRepository):bool
    {
        $apiKey = $apiKeyRepository->findOneBy(array("token" => $token));
        $fechaActual = DateTime::createFromFormat('Y-m-d H:i:s', date("Y-m-d H:i:s"));
        $id_usuario = Token::getPayload($token)["user_id"];
        $rol_name= Token::getPayload($token)["user_rol"];
        $usuario= $usuarioRepository->findOneBy(array("id" => $id_usuario));

        return $apiKey == null
            or $permisoRequerido == $rol_name
            or $apiKey->getIdUsuario()->getId() == $id_usuario
            or $apiKey->getFechaExpiracion() <= $fechaActual
            or Token::validate($token, $usuario->getPassword());
    }



}
