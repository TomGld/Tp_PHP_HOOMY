<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\Get;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\SettingDataRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SettingDataRepository::class)]
#[ApiResource(
    //autorisation des route que l'on veut acceder
    operations: [
        new Get(),
        new GetCollection(),
        new Patch(),
        new Post(),
    ],
    normalizationContext: ['groups' => ['settingData:read']],
    denormalizationContext: ['groups' => ['settingData:write']]
)]

#[ApiFilter(
    SearchFilter::class,
    properties: [
        'name' => 'iexact',
        'id' => 'exact',
        'vibe.id' => 'exact',
        'device.id' => 'exact',
        'settingType.id' => 'exact',
    ]
)]
class SettingData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['settingData:read', 'vibe:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'settingData')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['settingData:read','settingData:write' ,'vibe:read'])]
    private ?SettingType $settingType = null;

    #[ORM\Column(length: 25)]
    #[Groups(['settingData:read', 'settingData:write', 'room:read', 'vibe:read'])]
    private ?string $data = null;

    #[ORM\ManyToOne(inversedBy: 'settingData')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['settingData:read', 'settingData:write', 'room:read'])]
    private ?Vibe $vibe = null;

    #[ORM\ManyToOne(inversedBy: 'settingData')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['settingData:read', 'settingData:write', 'vibe:read'])]
    private ?Device $device = null;

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

    public function getDevice(): ?Device
    {
        return $this->device;
    }

    public function setDevice(?Device $device): static
    {
        $this->device = $device;

        return $this;
    }
}
