<?php

namespace PHPUnitStudy\Study\Tests\Models;

use PHPUnit\Framework\TestCase;
use PHPUnitStudy\Study\Exceptions\ConsecutiveBidsException;
use PHPUnitStudy\Study\Model\Auction;
use PHPUnitStudy\Study\Model\Bid;
use PHPUnitStudy\Study\Model\User;

class AuctionTest extends TestCase
{
    private Auction $auction;

    //**------- SET UP -------**//
    public function setUp(): void
    {
        $this->auction = new Auction('Fiat 147 0Km');
    }

    //**------- DATA PROVIDERS -------**//
    public function createAuctionWithOneBid(): array
    {
        $joao = new User('João');
        $bid1 = 3000;
        
        $auction = new Auction('Ferrari 1220 0 Km');
        $auction->addBid(new Bid($joao, $bid1));

        return [
            'Auction with one bid' => [1, $auction, [$bid1]]
        ];
    }

    public function createAuctionWithTwoBids(): array
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

    public function testAuctionShouldNotReceiveConsecutiveBidsFromTheSameUser(): void
    {
        //* Arrange
        $ana = new User('Ana');
        $validBidValue = 1500;

        //* Assert
        $this->expectException(ConsecutiveBidsException::class);
        $this->expectExceptionMessage('Same user can not throw consecutives bids.');

        //* Act
        $this->auction->addBid(new Bid($ana, $validBidValue));
        $this->auction->addBid(new Bid($ana, 2000));
    }
}
