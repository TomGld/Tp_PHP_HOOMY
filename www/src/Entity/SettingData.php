<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SettingDataRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SettingDataRepository::class)]
#[ApiResource]
class SettingData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'settingData')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SettingType $settingType = null;

    #[ORM\Column(length: 25)]
    private ?string $data = null;

    #[ORM\ManyToOne(inversedBy: 'settingData')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vibe $vibe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSettingType(): ?SettingType
    {
        return $this->settingType;
    }

    public function setSettingType(?SettingType $settingType): static
    {
        $this->settingType = $settingType;

        return $this;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(string $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getVibe(): ?Vibe
    {
        return $this->vibe;
    }

    public function setVibe(?Vibe $vibe): static
    {
        $this->vibe = $vibe;

        return $this;
    }
}
