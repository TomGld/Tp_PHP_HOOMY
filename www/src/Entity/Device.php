<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DeviceRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DeviceRepository::class)]
#[ApiResource(
    //autorisation des route que l'on veut acceder
    operations: [
        new Get(),
        new Post(),
        new Delete(),
        new GetCollection(),
        new Patch()
    ],
    normalizationContext: ['groups' => ['device:read']],
    denormalizationContext: ['groups' => ['device:write']]
)]

#[ApiFilter(
    SearchFilter::class,
    properties: [
        'name' => 'iexact',
        'id' => 'exact',
    ]
)]
class Device
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['device:read', 'vibe:read', 'settingData:read', 'room:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['device:read', 'device:write', 'room:read', 'vibe:read'])]
    private ?string $label = null;

    #[ORM\Column(length: 50)]
    #[Groups(['device:read', 'device:write', 'room:read', 'vibe:read'])]
    private ?string $type = null;

    #[ORM\Column]
    #[Groups(['device:read', 'device:write', 'room:read', 'vibe:read'])]
    private ?bool $isActive = null;

    #[ORM\Column(length: 50)]
    #[Groups(['device:read', 'device:write', 'room:read', 'vibe:read'])]
    private ?string $reference = null;

    #[ORM\Column(length: 50)]
    #[Groups(['device:read', 'device:write', 'room:read', 'vibe:read'])]
    private ?string $brand = null;

    /**
     * @var Collection<int, SettingType>
     */
    #[ORM\ManyToMany(targetEntity: SettingType::class, mappedBy: 'Device')]
    #[Groups(['device:read', 'room:read'])]
    private Collection $settingTypes;

    #[ORM\ManyToOne(inversedBy: 'devices')]
    #[Groups(['device:read','device:write', 'vibe:read'])]
    private ?Room $room = null;

    #[ORM\OneToMany(mappedBy: 'device', targetEntity: SettingData::class, cascade: ['persist', 'remove'])]
    #[Groups(['device:read', 'device:write'])]
    private Collection $settingData;

    public function __construct()
    {
        $this->settingTypes = new ArrayCollection();
        $this->settingData = new ArrayCollection();
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

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): static
    {
        $this->room = $room;

        return $this;
    }

    /**
     * @return Collection<int, SettingData>
     */
    public function getSettingData(): Collection
    {
        return $this->settingData;
    }

    public function addSettingData(SettingData $settingData): static
    {
        if (!$this->settingData->contains($settingData)) {
            $this->settingData->add($settingData);
            $settingData->setDevice($this);
        }

        return $this;
    }

    public function removeSettingData(SettingData $settingData): static
    {
        if ($this->settingData->removeElement($settingData)) {
            // Set the owning side to null (unless already changed)
            if ($settingData->getDevice() === $this) {
                $settingData->setDevice(null);
            }
        }

        return $this;
    }
}
