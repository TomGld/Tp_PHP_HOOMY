<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SettingTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SettingTypeRepository::class)]
#[ApiResource]
class SettingType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['vibe:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'settingTypes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['room:read', 'vibe:read'])]
    private ?DataType $dataType = null;

    #[ORM\Column(length: 25)]
    #[Groups(['vibe:read', 'room:read'])]
    private ?string $labelKey = null;

    /**
     * @var Collection<int, SettingData>
     */
    #[ORM\OneToMany(targetEntity: SettingData::class, mappedBy: 'settingType')]
    #[Groups(['room:read'])]
    private Collection $settingData;

    /**
     * @var Collection<int, Device>
     */
    #[ORM\ManyToMany(targetEntity: Device::class, inversedBy: 'settingTypes')]
    private Collection $Device;

    public function __construct()
    {
        $this->settingData = new ArrayCollection();
        $this->Device = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDataType(): ?DataType
    {
        return $this->dataType;
    }

    public function setDataType(?DataType $dataType): static
    {
        $this->dataType = $dataType;

        return $this;
    }

    public function getLabelKey(): ?string
    {
        return $this->labelKey;
    }

    public function setLabelKey(string $labelKey): static
    {
        $this->labelKey = $labelKey;

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
            $settingData->setSettingType($this);
        }

        return $this;
    }

    public function removeSettingData(SettingData $settingData): static
    {
        if ($this->settingData->removeElement($settingData)) {
            // set the owning side to null (unless already changed)
            if ($settingData->getSettingType() === $this) {
                $settingData->setSettingType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Device>
     */
    public function getDevice(): Collection
    {
        return $this->Device;
    }

    public function addDevice(Device $device): static
    {
        if (!$this->Device->contains($device)) {
            $this->Device->add($device);
        }

        return $this;
    }

    public function removeDevice(Device $device): static
    {
        $this->Device->removeElement($device);

        return $this;
    }
}
