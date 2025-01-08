<?php

namespace DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CalculateRepaymentScheduleQuery
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Range(
            min: 1000,
            max: 12000,
            notInRangeMessage: 'Kwota musi być z przedziału {{ min }} - {{ max }} i podzielna przez 500.'
        )]
        #[Assert\DivisibleBy(
            value: 500,
            message: 'Kwota musi być podzielna przez {{ value }}.'
        )]
        private readonly  int $principal,

        #[Assert\NotBlank]
        #[Assert\Range(
            min: 3,
            max: 18,
            notInRangeMessage: 'Liczba rat musi być z przedziału {{ min }} - {{ max }} i podzielna przez 3.'
        )]
        #[Assert\DivisibleBy(
            value: 3,
            message: 'Liczba rat musi być podzielna przez 3.'
        )]
        public readonly int $numnerOfInstallment
    ) {}
}
