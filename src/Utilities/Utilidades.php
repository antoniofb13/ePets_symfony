<?php

namespace App\Utilities;

use App\Entity\ApiKey;
use App\Entity\User;
use App\Repository\ApiKeyRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use ReallySimpleJWT\Token;



class Utilidades
{

    public function __construct(private ManagerRegistry $doctrine)
    {
    }


    public function toJson($data, ?array  $groups ): string
    {
        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups("user_query")->toArray();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);


        if($groups != null){
            //Conversion a JSON con groups
            $json = $serializer->serialize($data, 'json', $context);
        }else{
            //Conversion a JSON
            $json = $serializer->serialize($data, 'json');
        }

        return $json;
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

    public function esApiKeyValida($token, $permisoRequerido): bool
    {

        //Autowireds
        $em = $this->doctrine->getManager();
        $apiKeyRepository = $em->getRepository(ApiKey::class);
        $usuarioRepository = $em->getRepository(User::class);

        //Usuario que hace la peticion
        $idUsuario = Token::getPayload($token)['user_id'];

        $apiKey = $apiKeyRepository->findOneBy(array("token" => $token));
        $fechaActual = DateTime::createFromFormat('Y-m-d H:i:s', date("Y-m-d H:i:s"));
        $fechaExpiracion = Token::getPayload($token)['fecha_expiracion'];
        $rolName = Token::getPayload($token)['user_rol'];
        $usuario = $usuarioRepository->findOneBy(array("id" => $idUsuario));

        if ( $fechaExpiracion >= $fechaActual){
            $oldToken = $apiKeyRepository->findOneBy(array('usuario' => $usuario));
            $apiKeyRepository->remove($oldToken, true);
            return false;
        } else {
            return $apiKey == null
                or $permisoRequerido == $rolName                    //Preguntar a luis sobre esto
                or $apiKey->getIdUsuario()->getId() == $idUsuario
                or Token::validate($token, $usuario->getPassword());
        }

    }



    public function exSQL($sql): void
    {
        $config = new Configuration();

        $connectionParams = array(
            'dbname' => 'redsocial',
            'user' => 'root',
            'password' => 'root',
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
        );
        $conn = DriverManager::getConnection($connectionParams, $config);

        $stmt = $conn->query($sql);

        while ($row = $stmt->fetch()) {
            var_dump($row);
        }



    }



}
