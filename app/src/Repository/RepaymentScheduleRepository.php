<?php

namespace App\Repository;

use App\Entity\RepaymentSchedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RepaymentScheduleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RepaymentSchedule::class);
    }

    public function getLastRepaymentSchedules(int $limit = 4, ?string $excluded = 'all'): array
    {
        $qb = $this->createQueryBuilder('r');

        $qb->join('r.installment', 'in')
            ->orderBy('in.intrestValue', 'DESC');

        if ($excluded === 'not_excluded') {
            $qb->join('r.loanCalculation', 'lc')
                ->andWhere('lc.excluded = :isExcluded')
                ->setParameter('isExcluded', false);
        }

        $qb->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }
}
