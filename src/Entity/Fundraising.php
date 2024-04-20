<?php

namespace App\Entity;

use App\Repository\FundraisingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FundraisingRepository::class)]
class Fundraising
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 2)]
    private ?float $amount = null;

    /**
     * @var Collection<int, Contribution>
     */
    #[ORM\OneToMany(targetEntity: Contribution::class, mappedBy: 'fundraising')]
    private Collection $contributions;

    /**
     * @var Collection<int, Expenditure>
     */
    #[ORM\OneToMany(targetEntity: Expenditure::class, mappedBy: 'fundraising')]
    private Collection $expenditures;

    /**
     * @var Collection<int, Student>
     */
    #[ORM\ManyToMany(targetEntity: Student::class, inversedBy: 'fundraisings')]
    private Collection $participants;

    public function __construct()
    {
        $this->contributions = new ArrayCollection();
        $this->expenditures = new ArrayCollection();
        $this->participants = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return Collection<int, Contribution>
     */
    public function getContributions(): Collection
    {
        return $this->contributions;
    }

    public function addContribution(Contribution $contribution): static
    {
        if (!$this->contributions->contains($contribution)) {
            $this->contributions->add($contribution);
            $contribution->setFundraising($this);
        }

        return $this;
    }

    public function removeContribution(Contribution $contribution): static
    {
        if ($this->contributions->removeElement($contribution)) {
            // set the owning side to null (unless already changed)
            if ($contribution->getFundraising() === $this) {
                $contribution->setFundraising(null);
            }
        }

        return $this;
    }

    public function getTotalContributionsAmount(): float
    {
        $total = 0;
        foreach ($this->contributions as $contribution) {
            $total += $contribution->getAmount() ?? 0;
        }

        return $total;
    }

    /**
     * @return Collection<int, Expenditure>
     */
    public function getExpenditures(): Collection
    {
        return $this->expenditures;
    }

    public function addExpenditure(Expenditure $expenditure): static
    {
        if (!$this->expenditures->contains($expenditure)) {
            $this->expenditures->add($expenditure);
            $expenditure->setFundraising($this);
        }

        return $this;
    }

    public function removeExpenditure(Expenditure $expenditure): static
    {
        if ($this->expenditures->removeElement($expenditure)) {
            // set the owning side to null (unless already changed)
            if ($expenditure->getFundraising() === $this) {
                $expenditure->setFundraising(null);
            }
        }

        return $this;
    }

    public function getTotalExpendituresAmount(): float
    {
        $total = 0;
        foreach ($this->expenditures as $expenditure) {
            $total += $expenditure->getAmount() ?? 0;
        }

        return $total;
    }

    public function getTotalRemainingAmount(): float
    {
        return $this->getTotalContributionsAmount() - $this->getTotalExpendituresAmount();
    }

    /**
     * @return Collection<int, Student>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Student $participant): static
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
        }

        return $this;
    }

    public function removeParticipant(Student $participant): static
    {
        $this->participants->removeElement($participant);

        return $this;
    }
}
