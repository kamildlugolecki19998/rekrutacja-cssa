<?php

namespace App\Repository;

use App\Entity\Installment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class InstallmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Installment::class);
    }

    public function getLastInstllments(?string $filter = 'all', ?int $limit = 4): array
    {
        $qb = $this->createQueryBuilder('lc')
        ->join('lc.repaymentSchedule', 'rs') 
        ->join('rs.installments', 'i')      
        ->select('lc, SUM(i.interestValue) AS totalInterest')
        ->groupBy('lc.id');              

      
        if ($filter === 'not_excluded') {
            $qb->andWhere('i.excluded = :isExcluded')
            ->setParameter('isExcluded', false);
        }


        return $qb->orderBy('totalInterest', 'DESC')  
        ->setMaxResults(4)                
        ->getQuery()
        ->getResult();
    }
}
