<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProfileRepository;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
#[ApiResource(
    //autorisation des route que l'on veut acceder
    operations: [
        new Get(),
        new GetCollection(),
        new Patch()
    ],
    normalizationContext: ['groups' => ['profile:read']],
    denormalizationContext: ['groups' => ['profile:write']]
)]

#[ApiFilter(
    SearchFilter::class,
    properties: [
        'name' => 'iexact',
        'id' => 'exact',
        'pinCode' => 'exact'
    ]
)]
class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['profile:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'profiles')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['profile:read', 'profile:write'])]
    private ?Image $image = null;

    #[ORM\Column(length: 25)]
    #[Groups(['profile:read', 'profile:write'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['profile:read', 'profile:write'])]
    private ?int $pinCode = null;

    /**
     * @var Collection<int, Vibe>
     */
    #[ORM\OneToMany(targetEntity: Vibe::class, mappedBy: 'profile')]
    private Collection $vibes;

    public function __construct()
    {
        $this->vibes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPinCode(): ?int
    {
        return $this->pinCode;
    }

    public function setPinCode(int $pinCode): static
    {
        $this->pinCode = $pinCode;

        return $this;
    }

    /**
     * @return Collection<int, Vibe>
     */
    public function getVibes(): Collection
    {
        return $this->vibes;
    }

    public function addVibe(Vibe $vibe): static
    {
        if (!$this->vibes->contains($vibe)) {
            $this->vibes->add($vibe);
            $vibe->setProfile($this);
        }

        return $this;
    }

    public function removeVibe(Vibe $vibe): static
    {
        if ($this->vibes->removeElement($vibe)) {
            // set the owning side to null (unless already changed)
            if ($vibe->getProfile() === $this) {
                $vibe->setProfile(null);
            }
        }

        return $this;
    }
}
