<?php

namespace App\Entity;

use App\Repository\SweatShirtRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

#[ORM\Entity(repositoryClass: SweatShirtRepository::class)]
class SweatShirt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price = null;

    /**
     * @var Collection<int, SweatSizes>
     */
    #[ORM\ManyToMany(targetEntity: SweatSizes::class, mappedBy: 'sweatshirt')]
    private Collection $sweatSizes;

    #[ORM\Column]
    private ?bool $isTop = null;

    #[ORM\Column(length: 255)]
    private ?string $img = null;

    public function __construct()
    {
        $this->sweatSizes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public static function loadaValidatorMetaData(ClassMetadata $metadata): void {
        $metadata -> addPropertyConstraint(
            'size',
            new Assert\Choice(['XS', 'S', 'M', 'L', 'XL'])
        );
    }

    /**
     * @return Collection<int, SweatSizes>
     */
    public function getSweatSizes(): Collection
    {
        return $this->sweatSizes;
    }

    public function addSweatSize(SweatSizes $sweatSize): static
    {
        if (!$this->sweatSizes->contains($sweatSize)) {
            $this->sweatSizes->add($sweatSize);
            $sweatSize->addSweatshirt($this);
        }

        return $this;
    }

    public function removeSweatSize(SweatSizes $sweatSize): static
    {
        if ($this->sweatSizes->removeElement($sweatSize)) {
            $sweatSize->removeSweatshirt($this);
        }

        return $this;
    }

    public function isTop(): ?bool
    {
        return $this->isTop;
    }

    public function setTop(bool $isTop): static
    {
        $this->isTop = $isTop;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;

        return $this;
    }
}