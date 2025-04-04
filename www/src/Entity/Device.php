<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DeviceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeviceRepository::class)]
#[ApiResource]
class Device
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $label = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column(length: 50)]
    private ?string $reference = null;

    #[ORM\Column(length: 50)]
    private ?string $brand = null;

    /**
     * @var Collection<int, SettingType>
     */
    #[ORM\ManyToMany(targetEntity: SettingType::class, mappedBy: 'Device')]
    private Collection $settingTypes;

    public function __construct()
    {
        $this->settingTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection<int, SettingType>
     */
    public function getSettingTypes(): Collection
    {
        return $this->settingTypes;
    }

    public function addSettingType(SettingType $settingType): static
    {
        if (!$this->settingTypes->contains($settingType)) {
            $this->settingTypes->add($settingType);
            $settingType->addDevice($this);
        }

        return $this;
    }

    public function removeSettingType(SettingType $settingType): static
    {
        if ($this->settingTypes->removeElement($settingType)) {
            $settingType->removeDevice($this);
        }

        return $this;
    }
}
