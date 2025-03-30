<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardRepository::class)]
class Card
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $initialsName = null;

    #[ORM\Column(length: 255)]
    private ?string $frenchName = null;

    #[ORM\Column(length: 255)]
    private ?string $englishName = null;

    #[ORM\Column]
    private ?int $heightId = null;

    #[ORM\Column(length: 255)]
    private ?string $imageUrl = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInitialsName(): ?string
    {
        return $this->initialsName;
    }
    public function setInitialsName(string $initialsName): static
    {
        $this->initialsName = $initialsName;

        return $this;
    }

    public function getFrenchName(): ?string
    {
        return $this->frenchName;
    }
    public function setFrenchName(string $frenchName): static
    {
        $this->frenchName = $frenchName;

        return $this;
    }

    public function getEnglishName(): ?string
    {
        return $this->englishName;
    }
    public function setEnglishName(string $englishName): static
    {
        $this->englishName = $englishName;

        return $this;
    }

    public function getHeightId(): ?int
    {
        return $this->heightId;
    }
    public function setHeightId(int $heightId): static
    {
        $this->heightId = $heightId;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }
    
    public function setImageUrl(string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }
}
