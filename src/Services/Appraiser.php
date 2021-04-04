<?php

declare(strict_types=1);

namespace PHPUnitStudy\Study\Services;

use PHPUnitStudy\Study\Model\Auction;
use PHPUnitStudy\Study\Model\Bid;

class Appraiser
{
    private Bid $highestBid;

    public function evaluate(Auction $auction): void
    {
        $this->highestBid = $this->extractHighestBid($auction->getBids());
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

    /** @param array<Bid> $bids */
    private function extractHighestBid(array $bids): Bid
    {
        $highestBidIndex = 0;
        foreach ($bids as $forIndex => $bid) {
            if ($bid->getValue() > $bids[$highestBidIndex]->getValue()) {
                $highestBidIndex = $forIndex;
            }
        }

        return $bids[$highestBidIndex];
    }
}
