<?php

namespace App\Repository;

use App\Entity\DatosAnimales;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DatosAnimales>
 *
 * @method DatosAnimales|null find($id, $lockMode = null, $lockVersion = null)
 * @method DatosAnimales|null findOneBy(array $criteria, array $orderBy = null)
 * @method DatosAnimales[]    findAll()
 * @method DatosAnimales[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DatosAnimalesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DatosAnimales::class);
    }

    public function save(DatosAnimales $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DatosAnimales $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DatosAnimales[] Returns an array of DatosAnimales objects
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

//    public function findOneBySomeField($value): ?DatosAnimales
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
