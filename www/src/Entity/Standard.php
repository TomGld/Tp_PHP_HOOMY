<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\StandardRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StandardRepository::class)]
#[ApiResource]
class Standard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['vibe:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['vibe:read'])]
    private ?int $security = null;

    #[ORM\Column]
    #[Groups(['vibe:read'])]
    private ?int $energy = null;

    #[ORM\Column]
    #[Groups(['vibe:read'])]
    private ?int $emotion = null;

    #[ORM\Column]
    #[Groups(['vibe:read'])]
    private ?int $consciousness = null;

    #[ORM\OneToOne(mappedBy: 'standard', cascade: ['persist', 'remove'])]
    private ?Vibe $vibe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSecurity(): ?int
    {
        return $this->security;
    }

    public function setSecurity(int $security): static
    {
        $this->security = $security;

        return $this;
    }

    public function getEnergy(): ?int
    {
        return $this->energy;
    }

    public function setEnergy(int $energy): static
    {
        $this->energy = $energy;

        return $this;
    }

    public function getEmotion(): ?int
    {
        return $this->emotion;
    }

    public function setEmotion(int $emotion): static
    {
        $this->emotion = $emotion;

        return $this;
    }

    public function getConsciousness(): ?int
    {
        return $this->consciousness;
    }

    public function setConsciousness(int $consciousness): static
    {
        $this->consciousness = $consciousness;

        return $this;
    }

    public function getVibe(): ?Vibe
    {
        return $this->vibe;
    }

    public function setVibe(Vibe $vibe): static
    {
        // set the owning side of the relation if necessary
        if ($vibe->getStandard() !== $this) {
            $vibe->setStandard($this);
        }

        $this->vibe = $vibe;

        return $this;
    }
}
