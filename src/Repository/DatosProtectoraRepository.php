<?php

namespace App\Repository;

use App\Entity\DatosProtectora;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DatosProtectora>
 *
 * @method DatosProtectora|null find($id, $lockMode = null, $lockVersion = null)
 * @method DatosProtectora|null findOneBy(array $criteria, array $orderBy = null)
 * @method DatosProtectora[]    findAll()
 * @method DatosProtectora[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DatosProtectoraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DatosProtectora::class);
    }

    public function save(DatosProtectora $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DatosProtectora $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DatosProtectora[] Returns an array of DatosProtectora objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DatosProtectora
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
