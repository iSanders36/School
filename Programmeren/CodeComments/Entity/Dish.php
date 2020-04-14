<?php

class Dish
{
    private $id;
    private $name;
    private $subDishes;

    public function __construct()
    {
        $this->subDishes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSubDishes(): Collection
    {
        return $this->subDishes;
    }

    public function addSubDish(SubDish $subDish): self
    {
        if (!$this->subDishes->contains($subDish)) {
            $this->subDishes[] = $subDish;
            $subDish->setDish($this);
        }

        return $this;
    }

    public function removeSubDish(SubDish $subDish): self
    {
        if ($this->subDishes->contains($subDish)) {
            $this->subDishes->removeElement($subDish);
            if ($subDish->getDish() === $this) {
                $subDish->setDish(null);
            }
        }

        return $this;
    }
}
