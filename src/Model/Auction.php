<?php

declare(strict_types=1);

namespace PHPUnitStudy\Study\Model;

use PHPUnitStudy\Study\Exceptions\ConsecutiveBidsException;

class Auction
{
    /** @var array<Bid> $bids */
    private array $bids;
    private string $description;

    public function __construct(string $description)
    {
        $this->setDescription($description);
        $this->setBids([]);
    }

    public function addBid(Bid $bid): self
    {
        if ($this->isUserOfTheLastAddedBid($bid->getUser())) {
            throw new ConsecutiveBidsException(
                'Same user can not throw consecutives bids.'
            );
        }

        array_push($this->bids, $bid);
        return $this;
    }

    /** @return array<Bid> */
    public function getBids(): array
    {
        return $this->bids;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /** @param array<Bid> $bids */
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

    private function isUserOfTheLastAddedBid(User $user): bool
    {
        if (empty($this->bids)) {
            return false;
        }

        $lastAddedBid = $this->bids[array_key_last($this->bids)];
        if ($user !== $lastAddedBid->getUser()) {
            return false;
        }

        return true;
    }
}
