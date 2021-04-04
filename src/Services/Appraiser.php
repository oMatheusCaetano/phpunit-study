<?php

declare(strict_types=1);

namespace PHPUnitStudy\Study\Services;

use PHPUnitStudy\Study\Exceptions\EmptyAuctionException;
use PHPUnitStudy\Study\Exceptions\FinishedAuctionException;
use PHPUnitStudy\Study\Model\Auction;
use PHPUnitStudy\Study\Model\Bid;

class Appraiser
{
    private Bid $highestBid;

    /** @var array<Bid> */
    private array $threeHighestBids;

    /**
     * @param  array<Bid> $bids
     * @return array<Bid>
     */
    public static function sortBidsDesc(array $bids): array
    {
        usort($bids, static function (Bid $firstBid, Bid $secondBid) {
            return $secondBid->getValue() - $firstBid->getValue();
        });

        return $bids;
    }

    public function evaluate(Auction $auction): void
    {
        if ($auction->isFinished()) {
            throw new FinishedAuctionException(
                'Can not evaluate an finished.'
            );
        }

        if (empty($auction->getBids())) {
            throw new EmptyAuctionException(
                'Can not evaluate an auction with no bids.'
            );
        }

        $this
            ->setHighestBid($this->extractHighestBid($auction->getBids()))
            ->setThreeHighestBids($this->extractThreeHighestBids(
                $auction->getBids()
            ));
    }

    public function getHighestBid(): Bid
    {
        return $this->highestBid;
    }

    /** @return array<Bid> */
    public function getThreeHighestBids(): array
    {
        return $this->threeHighestBids;
    }

    public function setHighestBid(Bid $highestBid): self
    {
        $this->highestBid = $highestBid;
        return $this;
    }

    /** @param array<Bid> $threeHighestBids */
    public function setThreeHighestBids(array $threeHighestBids): self
    {
        $this->threeHighestBids = $threeHighestBids;
        return $this;
    }

    /** @param array<Bid> $bids */
    private function extractHighestBid(array $bids): Bid
    {
        $bids = self::sortBidsDesc($bids);
        return array_slice($bids, 0, 1)[0];
    }

    /**
     * @param  array<Bid> $bids
     * @return array<Bid>
     */
    private function extractThreeHighestBids(array $bids): array
    {
        $bids = self::sortBidsDesc($bids);
        return array_slice($bids, 0, 3);
    }
}
