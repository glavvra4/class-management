<?php

namespace App\Entity;

use App\Repository\ContributionRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContributionRepository::class)]
class Contribution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'contributions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fundraising $fundraising = null;

    #[ORM\ManyToOne(inversedBy: 'contributions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 20, scale: 2)]
    private ?float $amount = null;

    public function __toString(): string
    {
        return sprintf(
            "%s %s %s",
            $this->createdAt->format('d.m.Y'),
            $this->student->getLastname() . ' ' . $this->student->getFirstname(),
            number_format($this->amount ?? 0, 2, ',', ' ') . ' ₽'
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFundraising(): ?Fundraising
    {
        return $this->fundraising;
    }

    public function setFundraising(?Fundraising $fundraising): static
    {
        $this->fundraising = $fundraising;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): static
    {
        $this->student = $student;

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

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }
}
