<?php

namespace App\Repository;

use App\Entity\Membership;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Membership>
 */
class MembershipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Membership::class);
    }

    public function save(Membership $membership): void
    {
        $this->getEntityManager()->persist($membership);
        $this->getEntityManager()->flush();
    }

    public function findOneByOrganizationAndUserId(string $organizationId, string $userId): Membership | null
    {
        return $this->createQueryBuilder('m')
            ->select('m')
            ->addSelect('o')
            ->join('m.organization', 'o')
            ->where('m.organization = :organizationId AND m.user = :userId')
            ->setParameter('organizationId', $organizationId)
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getSingleResult();
    }

    //    /**
    //     * @return Membership[] Returns an array of Membership objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Membership
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
