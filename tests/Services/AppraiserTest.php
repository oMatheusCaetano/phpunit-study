<?php

namespace PHPUnitStudy\Study\Tests\Services;

use PHPUnit\Framework\TestCase;
use PHPUnitStudy\Study\Model\Auction;
use PHPUnitStudy\Study\Model\Bid;
use PHPUnitStudy\Study\Model\User;
use PHPUnitStudy\Study\Services\Appraiser;

class AppraiserTest extends TestCase
{
    public function testAppraiserShouldGetHighestBidFromAuctionInAscendingOrder(): void
    {
        $auction = new Auction('Ferrari 1220 0 Km');
        
        $maria = new User('Maria');
        $joao = new User('João');
        
        $highestBidValue = 2500;
        $auction->addBid(new Bid($joao, 2000));
        $auction->addBid(new Bid($maria, $highestBidValue));
        
        $appraiser = new Appraiser();
        $appraiser->evaluate($auction);
        
        self::assertEquals($highestBidValue, $appraiser->getHighestBid()->getValue());
    }

    public function testAppraiserShouldGetHighestBidFromAuctionInDescendingOrder(): void
    {
        $auction = new Auction('Ferrari 1220 0 Km');
        
        $maria = new User('Maria');
        $joao = new User('João');
        
        $highestBidValue = 2500;
        $auction->addBid(new Bid($maria, $highestBidValue));
        $auction->addBid(new Bid($joao, 2000));
        
        $appraiser = new Appraiser();
        $appraiser->evaluate($auction);
        
        self::assertEquals($highestBidValue, $appraiser->getHighestBid()->getValue());
    }

    public function testAppraiserShouldGetHighestBidFromAuctionInRandomOrder(): void
    {
        $auction = new Auction('Ferrari 1220 0 Km');
        
        $maria = new User('Maria');
        $joao = new User('João');
        
        $highestBidValue = 2500;
        $auction->addBid(new Bid($joao, 2000));
        $auction->addBid(new Bid($joao, 2200));
        $auction->addBid(new Bid($maria, $highestBidValue));
        $auction->addBid(new Bid($joao, 1000));
        $auction->addBid(new Bid($maria, 2150));
        
        $appraiser = new Appraiser();
        $appraiser->evaluate($auction);
        
        self::assertEquals($highestBidValue, $appraiser->getHighestBid()->getValue());
    }

    public function testAppraiserShouldGetThreeHighestBidsFromAuctionInAscendingOrder(): void
    {
        $auction = new Auction('Ferrari 1220 0 Km');
        
        $maria = new User('Maria');
        $joao = new User('João');
        $ana = new User('Ana');
        
        $highestBidValue1 = 4600;
        $highestBidValue2 = 4000;
        $highestBidValue3 = 3800;
        $auction->addBid(new Bid($joao, 1000));
        $auction->addBid(new Bid($ana, 2000));
        $auction->addBid(new Bid($maria, 2150));
        $auction->addBid(new Bid($ana, 2200));
        $auction->addBid(new Bid($joao, $highestBidValue3));
        $auction->addBid(new Bid($maria, $highestBidValue2));
        $auction->addBid(new Bid($ana, $highestBidValue1));
        
        $appraiser = new Appraiser();
        $appraiser->evaluate($auction);
        
        self::assertCount(3, $appraiser->getThreeHighestBids());
        self::assertEquals(
            $highestBidValue1,
            $appraiser->getThreeHighestBids()[0]->getValue()
        );
        self::assertEquals(
            $highestBidValue2,
            $appraiser->getThreeHighestBids()[1]->getValue()
        );
        self::assertEquals(
            $highestBidValue3,
            $appraiser->getThreeHighestBids()[2]->getValue()
        );
    }

    public function testAppraiserShouldGetThreeHighestBidsFromAuctionInDescendingOrder(): void
    {
        $auction = new Auction('Ferrari 1220 0 Km');
        
        $maria = new User('Maria');
        $joao = new User('João');
        $ana = new User('Ana');
        
        $highestBidValue1 = 4600;
        $highestBidValue2 = 4000;
        $highestBidValue3 = 3800;
        $auction->addBid(new Bid($ana, $highestBidValue1));
        $auction->addBid(new Bid($maria, $highestBidValue2));
        $auction->addBid(new Bid($joao, $highestBidValue3));
        $auction->addBid(new Bid($ana, 2200));
        $auction->addBid(new Bid($maria, 2150));
        $auction->addBid(new Bid($joao, 1000));
        $auction->addBid(new Bid($ana, 2000));
        
        $appraiser = new Appraiser();
        $appraiser->evaluate($auction);
        
        self::assertCount(3, $appraiser->getThreeHighestBids());
        self::assertEquals(
            $highestBidValue1,
            $appraiser->getThreeHighestBids()[0]->getValue()
        );
        self::assertEquals(
            $highestBidValue2,
            $appraiser->getThreeHighestBids()[1]->getValue()
        );
        self::assertEquals(
            $highestBidValue3,
            $appraiser->getThreeHighestBids()[2]->getValue()
        );
    }

    public function testAppraiserShouldGetThreeHighestBidsFromAuctionInRandomOrder(): void
    {
        $auction = new Auction('Ferrari 1220 0 Km');
        
        $maria = new User('Maria');
        $joao = new User('João');
        $ana = new User('Ana');
        
        $highestBidValue1 = 4600;
        $highestBidValue2 = 4000;
        $highestBidValue3 = 3800;
        $auction->addBid(new Bid($maria, $highestBidValue2));
        $auction->addBid(new Bid($ana, 2200));
        $auction->addBid(new Bid($joao, 1000));
        $auction->addBid(new Bid($ana, $highestBidValue1));
        $auction->addBid(new Bid($ana, 2000));
        $auction->addBid(new Bid($maria, 2150));
        $auction->addBid(new Bid($joao, $highestBidValue3));
        
        $appraiser = new Appraiser();
        $appraiser->evaluate($auction);
        
        self::assertCount(3, $appraiser->getThreeHighestBids());
        self::assertEquals(
            $highestBidValue1,
            $appraiser->getThreeHighestBids()[0]->getValue()
        );
        self::assertEquals(
            $highestBidValue2,
            $appraiser->getThreeHighestBids()[1]->getValue()
        );
        self::assertEquals(
            $highestBidValue3,
            $appraiser->getThreeHighestBids()[2]->getValue()
        );
    }
}
