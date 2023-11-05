<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\HashedData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HashedData>
 *
 * @method HashedData|null find($id, $lockMode = null, $lockVersion = null)
 * @method HashedData|null findOneBy(array $criteria, array $orderBy = null)
 * @method HashedData[]    findAll()
 * @method HashedData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HashedDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HashedData::class);
    }

    public function save(HashedData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HashedData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneByHashedData(string $hashedData): ?HashedData
    {
        return $this->findOneBy(['hashedData' => $hashedData]);
    }

    /**
     * @return HashedData[] Returns an array of HashedData objects
     */
    public function findByHash(string $hash): array
    {
        return $this->createQueryBuilder('hd')
            ->andWhere('hd.hashedData = :hash')
            ->setParameter('hash', $hash)
            ->getQuery()
            ->getResult()
            ;
    }
}
