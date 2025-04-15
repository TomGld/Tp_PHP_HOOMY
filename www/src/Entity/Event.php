<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ApiResource]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vibe $vibe = null;

    #[ORM\Column(length: 25)]
    #[Groups(['vibe:read'])]
    private ?string $label = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['vibe:read'])]
    private ?\DateTimeInterface $dateStart = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['vibe:read'])]
    private ?\DateTimeInterface $dateEnd = null;

    /**
     * @var Collection<int, Room>
     */
    #[ORM\ManyToMany(targetEntity: Room::class, inversedBy: 'events')]
    #[Groups(['vibe:read'])]
    private Collection $room;

    public function __construct()
    {
        $this->room = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): static
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): static
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * @return Collection<int, Room>
     */
    public function getRoom(): Collection
    {
        return $this->room;
    }

    public function addRoom(Room $room): static
    {
        if (!$this->room->contains($room)) {
            $this->room->add($room);
        }

        return $this;
    }

    public function removeRoom(Room $room): static
    {
        $this->room->removeElement($room);

        return $this;
    }
}
