<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\VibeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: VibeRepository::class)]
#[ApiResource(
    //autorisation des route que l'on veut acceder
    operations: [
        new Get(),
        new GetCollection(),
        new Patch()
    ],
    normalizationContext: ['groups' => ['vibe:read']],
    denormalizationContext: ['groups' => ['vibe:write']]
)]
class Vibe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, SettingData>
     */
    #[ORM\OneToMany(targetEntity: SettingData::class, mappedBy: 'vibe')]
    #[Groups(['vibe:read'])]
    private Collection $settingData;

    #[ORM\ManyToOne(inversedBy: 'vibes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profile $profile = null;

    #[ORM\ManyToOne(inversedBy: 'vibes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['vibe:read'])]
    private ?Image $image = null;

    #[ORM\Column(length: 25)]
    #[Groups(['vibe:read'])]
    private ?string $label = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'vibe')]
    #[Groups(['vibe:read'])]
    private Collection $events;

    #[ORM\OneToOne(inversedBy: 'vibe', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['vibe:read'])]
    private ?Standard $standard = null;

    public function __construct()
    {
        $this->settingData = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $settingData->setVibe($this);
        }

        return $this;
    }

    public function removeSettingData(SettingData $settingData): static
    {
        if ($this->settingData->removeElement($settingData)) {
            // set the owning side to null (unless already changed)
            if ($settingData->getVibe() === $this) {
                $settingData->setVibe(null);
            }
        }

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): static
    {
        $this->profile = $profile;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): static
    {
        $this->image = $image;

        return $this;
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

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setVibe($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getVibe() === $this) {
                $event->setVibe(null);
            }
        }

        return $this;
    }

    public function getStandard(): ?Standard
    {
        return $this->standard;
    }

    public function setStandard(Standard $standard): static
    {
        $this->standard = $standard;

        return $this;
    }
}
