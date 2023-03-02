<?php

namespace App\Repository;

use App\Entity\Publicaciones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Publicaciones>
 *
 * @method Publicaciones|null find($id, $lockMode = null, $lockVersion = null)
 * @method Publicaciones|null findOneBy(array $criteria, array $orderBy = null)
 * @method Publicaciones[]    findAll()
 * @method Publicaciones[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicacionesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publicaciones::class);
    }

    public function save(Publicaciones $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Publicaciones $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Publicaciones[]
     */
    public function buscarPorEstado(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.estado = false')
            ->orderBy('p.fecha_pub', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Publicaciones[]
     */
    public function buscarPorEstadoCerradoAndUser($idUser): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.estado = true')
            ->andWhere('p.user = :val')
            ->setParameter('val', $idUser)
            ->orderBy('p.fecha_pub', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Publicaciones[]
     */
    public function buscarPorTag($nombreTag): array
    {
        return $this->createQueryBuilder('p')
            ->join("p.tags", "t")
            ->andWhere('t.nombre LIKE :val')
            ->setParameter('val', '%'.$nombreTag.'%')
            ->orderBy('p.fecha_pub', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function buscarPorIdUser($idUser): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.estado = false')
            ->andWhere('p.user = :val')
            ->setParameter('val', $idUser)
            ->orderBy('p.fecha_pub', 'DESC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Publicaciones[] Returns an array of Publicaciones objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Publicaciones
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
