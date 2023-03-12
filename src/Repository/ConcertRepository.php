<?php

namespace App\Repository;

use App\Entity\Concert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Concert>
 *
 * @method Concert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Concert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Concert[]    findAll()
 * @method Concert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Concert::class);
    }

    public function save(Concert $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Concert $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findUpcoming(): array
    {
        return $this->getEntityManager()
            ->createQuery('
                SELECT c.id, ch.concertHallName, c.concertName, c.concertDate, c.status FROM App\Entity\Concert c 
                JOIN c.concertHall ch 
                WHERE c.concertDate > CURRENT_DATE() 
                    AND (c.status <> :status OR c.status IS NULL)
                ORDER BY c.concertDate ASC
                ')
            ->setParameter('status', 'canceled')
            ->getResult();
    }

    public function findByBand($id): array
    {
        return $this->getEntityManager()
            ->createQuery('
                SELECT c.id, c.concertName, c.concertDate, c.status FROM App\Entity\Concert c 
                JOIN c.bands b 
                WHERE c.concertDate > CURRENT_DATE() 
                    AND (c.status <> :status OR c.status IS NULL)
                    AND b.id = :id
                ORDER BY c.concertDate ASC
                ')
            ->setParameter('status', 'canceled')
            ->setParameter('id', $id)
            ->getResult();
    }

//    /**
//     * @return Concert[] Returns an array of Concert objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Concert
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
