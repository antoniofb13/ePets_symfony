<?php

namespace App\Repository;

use App\Entity\Asociaciones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Asociaciones>
 *
 * @method Asociaciones|null find($id, $lockMode = null, $lockVersion = null)
 * @method Asociaciones|null findOneBy(array $criteria, array $orderBy = null)
 * @method Asociaciones[]    findAll()
 * @method Asociaciones[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AsociacionesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Asociaciones::class);
    }

    public function save(Asociaciones $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Asociaciones $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Asociaciones[]
     */
    public function findLikeUsername($username): array{
        return $this->createQueryBuilder('a')
            ->join('a.user', 'u')
            ->andWhere('u.username LIKE :val')
            ->setParameter('val','%'.$username.'%')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Asociaciones[] Returns an array of Asociaciones objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Asociaciones
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
