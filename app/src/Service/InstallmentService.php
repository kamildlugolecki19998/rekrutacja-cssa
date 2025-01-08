<?php

namespace App\Service;

use App\Const\Financtial;
use App\Entity\Installment;
use App\Entity\RepaymentSchedule;
use App\Helper\IdentifierGeneratorHelper;
use Doctrine\ORM\EntityManagerInterface;
use Money\Money;

class InstallmentService
{
    public function __construct(private readonly EntityManagerInterface $entityManager) {}
    public function createInstallments(RepaymentSchedule $repaymentSchedule, int $monthlyLoanInstallment, int $totalNumberOfInstallments, Money $balance): void
    {
        for ($i = 0; $i < $totalNumberOfInstallments; $i++) {
            $intrestAmount = $balance->multiply(Financtial::MONTHLY_INTREST_RATE); // odsetki pierszej raty money
            $installmentPrincipalValue = $monthlyLoanInstallment - $intrestAmount->getAmount(); // kapital pierwszej raty

            $balance = $balance->subtract(new Money($installmentPrincipalValue, $intrestAmount->getCurrency()));

            if ($i === $totalNumberOfInstallments - 1) {
                $installmentPrincipalValue += $balance->getAmount();
                $balance = new Money(0, $balance->getCurrency());
            }

            $installment = new Installment();
            $this->entityManager->persist($installment);
            $repaymentSchedule->addInstallment($installment);

            $installment->setNumber(IdentifierGeneratorHelper::generateRandomPaymentNumber());
            $installment->setTotalValue($monthlyLoanInstallment);
            $installment->setPrincipalValue($installmentPrincipalValue);
            $installment->setInterestValue($intrestAmount->getAmount());
            $installment->setTotalBalanceLeft($balance->getAmount());
            $installment->setCurrency($balance->getCurrency());
            $installment->setDueDate((new \DateTime())->modify("+$i month"));
        }
    }
}
