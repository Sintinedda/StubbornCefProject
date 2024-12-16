<?php

namespace App\Entity;

use App\Repository\SweatShirtRepository;
use Doctrine\ORM\Mapping as ORM;

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

    #[ORM\Column]
    private ?bool $isTop;

    #[ORM\Column(length: 255)]
    private ?string $img = null;

    #[ORM\Column]
    private ?int $stock_xs;

    #[ORM\Column]
    private ?int $stock_s;

    #[ORM\Column]
    private ?int $stock_m;

    #[ORM\Column]
    private ?int $stock_l;

    #[ORM\Column]
    private ?int $stock_xl;

    public function __construct() {
        $this -> stock_xs = 0;
        $this -> stock_s = 0;
        $this -> stock_m = 0;
        $this -> stock_l = 0;
        $this -> stock_xl = 0;
        $this -> isTop = false;
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

    public function isIsTop(): ?bool
    {
        return $this->isTop;
    }

    public function setIsTop(bool $isTop): static
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

    public function getStockXs(): ?int
    {
        return $this->stock_xs;
    }

    public function setStockXs(int $stock_xs): static
    {
        $this->stock_xs = $stock_xs;

        return $this;
    }

    public function getStockS(): ?int
    {
        return $this->stock_s;
    }

    public function setStockS(int $stock_s): static
    {
        $this->stock_s = $stock_s;

        return $this;
    }

    public function getStockM(): ?int
    {
        return $this->stock_m;
    }

    public function setStockM(int $stock_m): static
    {
        $this->stock_m = $stock_m;

        return $this;
    }

    public function getStockL(): ?int
    {
        return $this->stock_l;
    }

    public function setStockL(int $stock_l): static
    {
        $this->stock_l = $stock_l;

        return $this;
    }

    public function getStockXl(): ?int
    {
        return $this->stock_xl;
    }

    public function setStockXl(int $stock_xl): static
    {
        $this->stock_xl = $stock_xl;

        return $this;
    }
}