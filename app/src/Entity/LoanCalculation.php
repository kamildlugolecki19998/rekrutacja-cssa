<?php

namespace App\Entity;

use App\Repository\LoanCalculationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoanCalculationRepository::class)]
class LoanCalculation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // #[ORM\ManyToOne(inversedBy: 'loanCalculations')]
    // #[ORM\JoinColumn(nullable: true)]
    // private ?User $user = null;

    #[ORM\Column]
    private ?int $totalPrincipal = null;

    #[ORM\Column(length: 3)]
    private ?string $currency = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4)]
    private ?string $annualIntrestRate = null;

    #[ORM\Column]
    private ?int $numberOfPayments = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\Column]
    private bool $excluded = false;
    
    #[ORM\OneToOne(mappedBy: 'loanCalculation', cascade: ['persist', 'remove'])]
    private ?RepaymentSchedule $repaymentSchedule = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
    }    
    
    public function getId(): ?int
    {
        return $this->id;
    }

    // public function getUser(): ?User
    // {
    //     return $this->user;
    // }

    // public function setUser(?User $user): static
    // {
    //     $this->user = $user;

    //     return $this;
    // }

    public function getTotalPrincipal(): ?int
    {
        return $this->totalPrincipal;
    }

    public function setTotalPrincipal(int $principal): static
    {
        $this->totalPrincipal = $principal;

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

    public function getAnnualIntrestRate(): ?string
    {
        return $this->annualIntrestRate;
    }

    public function setAnnualIntrestRate(string $annualIntrestRate): static
    {
        $this->annualIntrestRate = $annualIntrestRate;

        return $this;
    }

    public function getNumberOfPayments(): ?int
    {
        return $this->numberOfPayments;
    }

    public function setNumberOfPayments(int $numberOfPayments): static
    {
        $this->numberOfPayments = $numberOfPayments;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isExcluded(): ?bool
    {
        return $this->excluded;
    }

    public function setExcluded(bool $excluded): static
    {
        $this->excluded = $excluded;

        return $this;
    }

    public function getRepaymentSchedule(): ?RepaymentSchedule
    {
        return $this->repaymentSchedule;
    }

    public function setRepaymentSchedule(RepaymentSchedule $repaymentSchedule): static
    {
        // set the owning side of the relation if necessary
        if ($repaymentSchedule->getLoanCalculation() !== $this) {
            $repaymentSchedule->setLoanCalculation($this);
        }

        $this->repaymentSchedule = $repaymentSchedule;

        return $this;
    }
}
