<?php

namespace App\DTO\Response;

use App\Entity\Installment;
use App\Interface\DTOResponseInterface;
use Doctrine\Common\Collections\Collection;

class CalculatedRepaymentSchedule implements DTOResponseInterface
{
    public function __construct(
        public \DateTimeInterface $calculationDate,
        public int $totalNumberOfInstallments,
        public string $principalValue,
        public float $annualInterestRate,
        public Collection $installments
    ) {
        $this->installments = $installments->map(function (Installment $installment): array {
            return (new InstallmentSchedule(
                $installment->getNumber(),
                $installment->getTotalValue(),
                $installment->getPrincipalValue(),
                $installment->getIntrestValue()
            ))->getReponseArray();
        });
    }

    public function getReponseArray(): array
    {
        return [
            'calculationDate' => $this->calculationDate->format('Y-m-d H:i:s'),
            'totalNumberOfInstallments' => $this->totalNumberOfInstallments,
            'principalValue' => number_format($this->principalValue / 100, 2, '.', ''),
            'annualInterestRate' => number_format($this->annualInterestRate, 2, '.', '') .'%',
            'installments' => $this->installments->toArray()
        ];
    }
}