<?php

namespace App\DTO\Query;

use Symfony\Component\Validator\Constraints as Assert;

class RepaymentQueryFilter
{
    public function __construct(
        #[Assert\Choice(
            choices: ['all', 'not_excluded'],
            message: 'Invalid filter value. Allowed values: all, not_excluded'
         )]
        public ?string $filter = 'all',
    ) {
    }
}
