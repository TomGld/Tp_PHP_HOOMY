<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[ApiResource]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $imagePath = null;

    #[ORM\OneToOne(mappedBy: 'image', cascade: ['persist', 'remove'])]
    private ?Room $room = null;

    #[ORM\Column]
    private ?int $category = null;

    /**
     * @var Collection<int, Profile>
     */
    #[ORM\OneToMany(targetEntity: Profile::class, mappedBy: 'image')]
    private Collection $profiles;

    /**
     * @var Collection<int, Vibe>
     */
    #[ORM\OneToMany(targetEntity: Vibe::class, mappedBy: 'image')]
    private Collection $vibes;

    public function __construct()
    {
        $this->profiles = new ArrayCollection();
        $this->vibes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): static
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): static
    {
        // unset the owning side of the relation if necessary
        if ($room === null && $this->room !== null) {
            $this->room->setImage(null);
        }

        // set the owning side of the relation if necessary
        if ($room !== null && $room->getImage() !== $this) {
            $room->setImage($this);
        }

        $this->room = $room;

        return $this;
    }

    public function getCategory(): ?int
    {
        return $this->category;
    }

    public function setCategory(int $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Profile>
     */
    public function getProfiles(): Collection
    {
        return $this->profiles;
    }

    public function addProfile(Profile $profile): static
    {
        if (!$this->profiles->contains($profile)) {
            $this->profiles->add($profile);
            $profile->setImage($this);
        }

        return $this;
    }

    public function removeProfile(Profile $profile): static
    {
        if ($this->profiles->removeElement($profile)) {
            // set the owning side to null (unless already changed)
            if ($profile->getImage() === $this) {
                $profile->setImage(null);
            }
        }

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
            $vibe->setImage($this);
        }

        return $this;
    }

    public function removeVibe(Vibe $vibe): static
    {
        if ($this->vibes->removeElement($vibe)) {
            // set the owning side to null (unless already changed)
            if ($vibe->getImage() === $this) {
                $vibe->setImage(null);
            }
        }

        return $this;
    }
}
