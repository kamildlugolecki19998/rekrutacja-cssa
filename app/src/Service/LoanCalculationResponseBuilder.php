<?php

namespace App\Service;

use App\Entity\LoanCalculation;
use App\Interface\ResponseCollectionBuilderInterface;
use Doctrine\Common\Collections\Collection;
use DTO\Response\LoanCalculations;

class LoanCalculationResponseBuilder implements ResponseCollectionBuilderInterface
{
    public function __construct(private readonly CalculatedRepaymentScheduleResponseBuilder $calculatedRepaymentScheduleBuilder){}
    public function buildResponse(array|Collection $collection): array
    {
        if (!$collection instanceof Collection && !is_array($collection)) {
            throw new \InvalidArgumentException('There is no possible to create response basne on given object type');
        }

        foreach ($collection as $key => $element) {
            if (!$element[0] instanceof LoanCalculation) {
                throw new \InvalidArgumentException('There is no possible to create response basne on given= ' . $element[$key]::class);
            }

            $response[] = (new LoanCalculations(
                $element[0]->getCreatedAt(),
                $element[0]->getNumberOfPayments(),
                $element[0]->getAnnualIntrestRate(),
                $element[0]->isExcluded(),
                $element[0]->getTotalPrincipal(),
                $element['totalInterestValue'],
                $element[0]->getRepaymentSchedule()->getInstallments()
            ))->getReponseArray();
        }

        return $response;
    }
}
