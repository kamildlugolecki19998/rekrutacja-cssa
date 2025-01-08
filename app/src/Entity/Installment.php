<?php

namespace App\Entity;

use App\Repository\InstallmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstallmentRepository::class)]
class Installment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'installments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?RepaymentSchedule $repaymentSchedule = null;

    #[ORM\Column]
    private ?string $number = null;

    #[ORM\Column]
    private ?int $totalValue = null;

    #[ORM\Column]
    private ?int $interestValue = null;

    #[ORM\Column]
    private ?int $principalValue = null;

    #[ORM\Column(length: 3)]
    private ?string $currency = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dueDate = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $totalBalanceLeft = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRepaymentSchedule(): ?RepaymentSchedule
    {
        return $this->repaymentSchedule;
    }

    public function setRepaymentSchedule(?RepaymentSchedule $repaymentSchedule): static
    {
        $this->repaymentSchedule = $repaymentSchedule;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getTotalValue(): ?int
    {
        return $this->totalValue;
    }

    public function setTotalValue(int $totalValue): static
    {
        $this->totalValue = $totalValue;

        return $this;
    }

    public function getIntrestValue(): ?int
    {
        return $this->interestValue;
    }

    public function setInterestValue(int $intrestValue): static
    {
        $this->interestValue = $intrestValue;

        return $this;
    }

    public function getPrincipalValue(): ?int
    {
        return $this->principalValue;
    }

    public function setPrincipalValue(int $principalValue): static
    {
        $this->principalValue = $principalValue;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTimeInterface $dueDate): static
    {
        $this->dueDate = $dueDate;

        return $this;
    }
    
    public function getTotalBalanceLeft(): ?int
    {
        return $this->totalBalanceLeft;
    }

    public function setTotalBalanceLeft(?int $totalBalanceLeft): static
    {
        $this->totalBalanceLeft = $totalBalanceLeft;

        return $this;
    }
}
