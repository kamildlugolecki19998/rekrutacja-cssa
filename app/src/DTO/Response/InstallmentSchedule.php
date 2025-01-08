<?php

namespace App\DTO\Response;

use App\Interface\DTOResponseInterface;

class InstallmentSchedule implements DTOResponseInterface
{
    public function __construct(
        public string $number,
        public string $totalValue,
        public string $principalValue,
        public string $interestValue
    ) {}

    public function getReponseArray(): array
    {
        return [
            'number'         => $this->number,
            'totalvalue'     => $this->totalValue = number_format($this->totalValue / 100, 2, '.', ''),
            'principalValue' => $this->principalValue = number_format($this->principalValue / 100, 2, '.', ''),
            'interstValue'   => $this->interestValue = number_format($this->interestValue / 100, 2, '.', ''),
        ];
    }
}
