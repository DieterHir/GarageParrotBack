<?php

namespace App\Entity;

use App\Repository\TemoignagesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TemoignagesRepository::class)]
class Temoignages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['temoignages'])]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    #[Groups(['temoignages'])]
    private ?string $FirstName = null;

    #[ORM\Column(length: 32)]
    #[Groups(['temoignages'])]
    private ?string $LastName = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['temoignages'])]
    private ?string $Commentary = null;

    #[ORM\Column]
    #[Groups(['temoignages'])]
    private ?int $Note = null;

    #[ORM\Column]
    #[Groups(['temoignages'])]
    private ?int $Approved = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['temoignages'])]
    private ?\DateTimeInterface $CreatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $UpdatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'temoignages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Garage $Garage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): static
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): static
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getCommentary(): ?string
    {
        return $this->Commentary;
    }

    public function setCommentary(string $Commentary): static
    {
        $this->Commentary = $Commentary;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->Note;
    }

    public function setNote(int $Note): static
    {
        $this->Note = $Note;

        return $this;
    }

    public function getApproved(): ?int
    {
        return $this->Approved;
    }

    public function setApproved(int $Approved): static
    {
        $this->Approved = $Approved;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): static
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $UpdatedAt): static
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

    public function getGarage(): ?Garage
    {
        return $this->Garage;
    }

    public function setGarage(?Garage $Garage): static
    {
        $this->Garage = $Garage;

        return $this;
    }
}
