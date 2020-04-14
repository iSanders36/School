<?php

class Receipt
{
    private $id;
    private $reservation;
    private $payed;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }

    public function getPayed()
    {
        return $this->payed;
    }

    public function setPayed($payed): self
    {
        $this->payed = $payed;

        return $this;
    }
}
