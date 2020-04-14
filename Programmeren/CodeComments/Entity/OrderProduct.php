<?php

class OrderProduct
{
    private $id;
    private $MainOrder;
    private $Product;
    private $count;
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMainOrder(): ?Order
    {
        return $this->MainOrder;
    }

    public function setMainOrder(?Order $MainOrder): self
    {
        $this->MainOrder = $MainOrder;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->Product;
    }

    public function setProduct(?Product $Product): self
    {
        $this->Product = $Product;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }
}
