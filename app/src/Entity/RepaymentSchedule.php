<?php

namespace App\Entity;

use App\Repository\RepaymentScheduleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RepaymentScheduleRepository::class)]
class RepaymentSchedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'repaymentSchedule', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?LoanCalculation $loanCalculation = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Installment>
     */
    #[ORM\OneToMany(targetEntity: Installment::class, mappedBy: 'repaymentSchedule', orphanRemoval: true)]
    private Collection $installments;

    public function __construct()
    {
        $this->installments = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLoanCalculation(): ?LoanCalculation
    {
        return $this->loanCalculation;
    }

    public function setLoanCalculation(LoanCalculation $loanCalculation): static
    {
        $this->loanCalculation = $loanCalculation;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Installment>
     */
    public function getInstallments(): Collection
    {
        return $this->installments;
    }

    public function addInstallment(Installment $installment): static
    {
        if (!$this->installments->contains($installment)) {
            $this->installments->add($installment);
            $installment->setRepaymentSchedule($this);
        }

        return $this;
    }

    public function removeInstallment(Installment $installment): static
    {
        if ($this->installments->removeElement($installment)) {
            // set the owning side to null (unless already changed)
            if ($installment->getRepaymentSchedule() === $this) {
                $installment->setRepaymentSchedule(null);
            }
        }

        return $this;
    }
}
