<?php

namespace App\Entity;

use App\Repository\SweatSizesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SweatSizesRepository::class)]
class SweatSizes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private array $size = ['XS', 'S', 'M', 'L', 'XL'];

    /**
     * @var Collection<int, SweatShirt>
     */
    #[ORM\ManyToMany(targetEntity: SweatShirt::class, inversedBy: 'sweatSizes')]
    private Collection $sweatshirt;

    #[ORM\Column]
    private ?int $stock = null;

    public function __construct()
    {
        $this->sweatshirt = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSize(): array
    {
        return $this->size;
    }

    public function setSize(array $size): static
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return Collection<int, SweatShirt>
     */
    public function getSweatshirt(): Collection
    {
        return $this->sweatshirt;
    }

    public function addSweatshirt(SweatShirt $sweatshirt): static
    {
        if (!$this->sweatshirt->contains($sweatshirt)) {
            $this->sweatshirt->add($sweatshirt);
        }

        return $this;
    }

    public function removeSweatshirt(SweatShirt $sweatshirt): static
    {
        $this->sweatshirt->removeElement($sweatshirt);

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }
}
