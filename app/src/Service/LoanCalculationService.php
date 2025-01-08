<?php

namespace App\Service;

use App\Entity\LoanCalculation;
use Doctrine\ORM\EntityManagerInterface;

class LoanCalculationService
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function createLoanCalculation(int $toalPrincipal, float $annualIntrestRate, int $totalNumberOfPayments, string $currency): LoanCalculation
    {
        $loacalculation = new LoanCalculation();

        $this->entityManager->persist($loacalculation);

        $loacalculation->setTotalPrincipal($toalPrincipal);
        $loacalculation->setAnnualIntrestRate((string)$annualIntrestRate * 100);
        $loacalculation->setNumberOfPayments($totalNumberOfPayments);
        $loacalculation->setCurrency($currency);

        return $loacalculation;
    }
}
