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
}
