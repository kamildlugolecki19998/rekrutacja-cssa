<?php

namespace App\Repository;

use App\Entity\LoanCalculation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LoanCalculation>
 */
class LoanCalculationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoanCalculation::class);
    }

    public function getLastCalcualtions(?string $excludedFilter, int $limit = 4): array
    {
        $qb = $this->createQueryBuilder('lc')
            ->join('lc.repaymentSchedule', 'rs')
            ->join('rs.installments', 'i')
            ->select('lc, SUM(i.interestValue) AS totalInterestValue')
            ->groupBy('lc.id');

        if ($excludedFilter === 'not_excluded') {
            $qb->andWhere('lc.excluded = :isExcluded')
                ->setParameter('isExcluded', false);
        }

        return $qb->orderBy('totalInterestValue', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
