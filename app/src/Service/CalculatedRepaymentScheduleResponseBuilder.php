<?php

namespace App\Service;

use App\DTO\Response\CalculatedRepaymentSchedule;
use App\Entity\RepaymentSchedule;
use App\Interface\DTOResponseInterface;
use App\Interface\ResponseBuilderInterface;

class CalculatedRepaymentScheduleResponseBuilder implements ResponseBuilderInterface
{
    public function buildResponse(object $entity): DTOResponseInterface
    {
        if (!$entity instanceof RepaymentSchedule) {
            throw new \InvalidArgumentException('There is no possible to create response basne on given= ' .  $entity::class);
        }

        return new CalculatedRepaymentSchedule(
            $entity->getCreatedAt(),
            $entity->getLoanCalculation()->getNumberOfPayments(),
            $entity->getLoanCalculation()->getTotalPrincipal(),
            $entity->getLoanCalculation()->getAnnualIntrestRate(),
            $entity->getInstallments()
        );
    }
}
