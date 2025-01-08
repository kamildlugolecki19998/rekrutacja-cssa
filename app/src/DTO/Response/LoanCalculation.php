<?php

namespace DTO\Response;

use App\DTO\Response\InstallmentSchedule;
use App\Entity\Installment;
use App\Interface\DTOResponseInterface;
use Doctrine\Common\Collections\Collection;

class LoanCalculations implements DTOResponseInterface
{
    public function __construct(
        public \DateTimeInterface $createdAt,
        public string $nubmerOfPayments,
        public string $annaualInterestRate,
        public bool $excluded,
        public string $totalPrincipal,
        public string $totalInterestValue, 
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
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'nubmerOfPayments' => $this->nubmerOfPayments,
            'annaualInterestRate' => number_format($this->annaualInterestRate, 2, '.', ''),
            'excluded' => $this->excluded,
            'totalPrincipal' => number_format($this->totalPrincipal, 2, '.', ''),
            'totalInterestValue' => number_format($this->totalInterestValue / 100, 2, '.', ''),
            'installments' => $this->installments->toArray()
        ];
    }
}