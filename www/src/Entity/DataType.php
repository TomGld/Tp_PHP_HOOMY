<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DataTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DataTypeRepository::class)]
#[ApiResource]
class DataType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['room:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    #[Groups(['vibe:read', 'room:read'])]
    private ?string $dataType = null;

    /**
     * @var Collection<int, SettingType>
     */
    #[ORM\OneToMany(targetEntity: SettingType::class, mappedBy: 'dataType')]
    private Collection $settingTypes;

    public function __construct()
    {
        $this->settingTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDataType(): ?string
    {
        return $this->dataType;
    }

    public function setDataType(string $dataType): static
    {
        $this->dataType = $dataType;

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
            $settingType->setDataType($this);
        }

        return $this;
    }

    public function removeSettingType(SettingType $settingType): static
    {
        if ($this->settingTypes->removeElement($settingType)) {
            // set the owning side to null (unless already changed)
            if ($settingType->getDataType() === $this) {
                $settingType->setDataType(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->dataType;
    }
}
