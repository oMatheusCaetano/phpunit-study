<?php

namespace PHPUnitStudy\Study\Model;

class Auction
{
    private array $bids;
    private string $description;

    public function __construct(string $description)
    {
        $this->setDescription($description);
        $this->setBids([]);
    }

    public function addBid(Bid $bid): self
    {
        array_push($this->bids, $bid);
        return $this;
    }

    public function getBids(): array
    {
        return $this->bids;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setBids(array $bids): self
    {
        $this->bids = $bids;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }
}
