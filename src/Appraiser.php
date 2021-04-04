<?php

declare(strict_types=1);

namespace PHPUnitStudy\Study;

use PHPUnitStudy\Study\Model\Auction;
use PHPUnitStudy\Study\Model\Bid;

class Appraiser
{
    private Bid $highestBid;

    public function evaluate(Auction $auction): void
    {
        $bids = $auction->getBids();
        $this->highestBid = $bids[array_key_last($bids)];
    }

    public function getHighestBid(): Bid
    {
        return $this->highestBid;
    }

    public function setHighestBid(Bid $highestBid): self
    {
        $this->highestBid = $highestBid;
        return $this;
    }
}
