<?php

namespace PHPUnitStudy\Study\Tests\Models;

use PHPUnit\Framework\TestCase;
use PHPUnitStudy\Study\Model\Auction;
use PHPUnitStudy\Study\Model\Bid;
use PHPUnitStudy\Study\Model\User;

class AuctionTest extends TestCase
{
    //**------- DATA PROVIDERS -------**//
    public function createAuctionWithOneBid()
    {
        $joao = new User('João');
        $bid1 = 3000;
        
        $auction = new Auction('Ferrari 1220 0 Km');
        $auction->addBid(new Bid($joao, $bid1));

        return [
            'Auction with one bid' => [1, $auction, [$bid1]]
        ];
    }

    public function createAuctionWithTwoBids()
    {
        $maria = new User('Maria');
        $joao = new User('João');
        $bid1 = 3000;
        $bid2 = 5000;

        $auction = new Auction('Ferrari 1220 0 Km');
        $auction->addBid(new Bid($joao, $bid1));
        $auction->addBid(new Bid($maria, $bid2));

        return [
            'Auction with two bids' => [2, $auction, [$bid1, $bid2]]
        ];
    }

    //**------- TESTS -------**//

    /**
     * @dataProvider createAuctionWithOneBid
     * @dataProvider createAuctionWithTwoBids
     * 
     * @param array<float> $bidsValues
     */
    public function testAuctionShouldReceiveBids(
        int $quantityOfBids,
        Auction $auction,
        array $bidsValues
    ): void {
        //* Assert
        self::assertCount($quantityOfBids, $auction->getBids());

        foreach ($bidsValues as $index => $bidValue) {        
            self::assertEquals($bidValue, $auction->getBids()[$index]->getValue());
        }
    }
}