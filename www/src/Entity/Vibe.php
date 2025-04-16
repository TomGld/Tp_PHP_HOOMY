<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\Get;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\VibeRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
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

#[ApiFilter(
    SearchFilter::class,
    properties: [
        'name' => 'iexact',
        'id' => 'exact',
    ]
)]
class Vibe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['vibe:read'])]
    private ?int $id = null;

    /**
     * @var Collection<int, SettingData>
     */
    #[ORM\OneToMany(targetEntity: SettingData::class, mappedBy: 'vibe')]

    #[Groups(['vibe:read'])]
    private Collection $settingData;

    #[ORM\ManyToOne(inversedBy: 'vibes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['vibe:read', 'vibe:write'])]
    private ?Profile $profile = null;

    #[ORM\ManyToOne(inversedBy: 'vibes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['vibe:read', 'room:read'])]
    private ?Image $image = null;

    #[ORM\Column(length: 25)]
    #[Groups(['vibe:read', 'vibe:write', 'room:read'])]
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

    /**
     * @var Collection<int, Room>
     */
    #[ORM\ManyToMany(targetEntity: Room::class, mappedBy: 'vibe')]
    #[Groups(['vibe:read'])]
    private Collection $rooms;

    public function __construct()
    {
        $this->settingData = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->rooms = new ArrayCollection();
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

    /**
     * @return Collection<int, Room>
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Room $room): static
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms->add($room);
            $room->addVibe($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): static
    {
        if ($this->rooms->removeElement($room)) {
            $room->removeVibe($this);
        }

        return $this;
    }
}
