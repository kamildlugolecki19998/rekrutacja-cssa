<?php

namespace App\Service;

use App\Const\Financtial;
use App\Entity\RepaymentSchedule;
use App\Helper\FinanctialHelper;
use App\Service\LoanCalculationService;
use Doctrine\ORM\EntityManagerInterface;
use DTO\Payload\CalculateRepaymentSchedule;

class CalculateRepaymentScheduleService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly InstallmentService $insallmentService,
        private readonly LoanCalculationService $loanCalculationService
    ) {}

    public function calculateRepaymentSchedule(CalculateRepaymentSchedule $calculateRepaymentSchedule): RepaymentSchedule
    {
        $this->entityManager->beginTransaction();

        try {
            $monthlyLoanInstallment = $this->calculateMonthlyLoanInstallment(
                $calculateRepaymentSchedule->money->getAmount(),
                $calculateRepaymentSchedule->totalNumberOfInstallments
            );

            $loanCalculation = $this->loanCalculationService->createLoanCalculation(
                $calculateRepaymentSchedule->money->getAmount(),
                Financtial::ANNUAL_INTREST_RATE,
                $calculateRepaymentSchedule->totalNumberOfInstallments,
                $calculateRepaymentSchedule->money->getCurrency()->getCode()
            );

            $repaymentSchedule = new RepaymentSchedule();
            $this->entityManager->persist($repaymentSchedule);
            $repaymentSchedule->setLoanCalculation($loanCalculation);

            $this->insallmentService->createInstallments(
                $repaymentSchedule,
                $monthlyLoanInstallment,
                $calculateRepaymentSchedule->totalNumberOfInstallments,
                $calculateRepaymentSchedule->money
            );
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }

        $this->entityManager->flush();
        $this->entityManager->commit();

        return $repaymentSchedule;
    }

    private function calculateMonthlyLoanInstallment(int $principal, int $totalNumberOfInstallments): int
    {
        $accumulationCompoundFactor = FinanctialHelper::calculateCompoundAccumulationFactor(totalNumberOfInstallments: $totalNumberOfInstallments);             
        $intrestGrowthNumerator = FinanctialHelper::calculateIntrestGrowthNumerator($accumulationCompoundFactor);
        $cumulativeGrowthDifference = FinanctialHelper::calculateCumulativeGrowthDifference($accumulationCompoundFactor);

        $monthlyPayment = $principal * ($intrestGrowthNumerator / $cumulativeGrowthDifference);

        return (int) round($monthlyPayment);
    }
}
