<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $deletedAt = null;

    /**
     * @var Collection<int, Contribution>
     */
    #[ORM\OneToMany(targetEntity: Contribution::class, mappedBy: 'student')]
    private Collection $contributions;

    /**
     * @var Collection<int, Fundraising>
     */
    #[ORM\ManyToMany(targetEntity: Fundraising::class, mappedBy: 'participants')]
    private Collection $fundraisings;

    public function __construct()
    {
        $this->contributions = new ArrayCollection();
        $this->fundraisings = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->lastname . ' ' . $this->firstname;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

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
            $contribution->setStudent($this);
        }

        return $this;
    }

    public function removeContribution(Contribution $contribution): static
    {
        if ($this->contributions->removeElement($contribution)) {
            // set the owning side to null (unless already changed)
            if ($contribution->getStudent() === $this) {
                $contribution->setStudent(null);
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
     * @return Collection<int, Fundraising>
     */
    public function getFundraisings(): Collection
    {
        return $this->fundraisings;
    }

    public function addFundraising(Fundraising $fundraising): static
    {
        if (!$this->fundraisings->contains($fundraising)) {
            $this->fundraisings->add($fundraising);
            $fundraising->addParticipant($this);
        }

        return $this;
    }

    public function removeFundraising(Fundraising $fundraising): static
    {
        if ($this->fundraisings->removeElement($fundraising)) {
            $fundraising->removeParticipant($this);
        }

        return $this;
    }

    public function getTotalFundraisingsAmount(): float
    {
        $total = 0;
        foreach ($this->fundraisings as $fundraising) {
            $total += $fundraising->getAmount() ?? 0;
        }

        return $total;
    }

    public function getTotalDebtAmount(): float
    {
        return $this->getTotalFundraisingsAmount() - $this->getTotalContributionsAmount();
    }
}
