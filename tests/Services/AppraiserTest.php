<?php

namespace PHPUnitStudy\Study\Tests\Services;

use PHPUnit\Framework\TestCase;
use PHPUnitStudy\Study\Model\Auction;
use PHPUnitStudy\Study\Model\Bid;
use PHPUnitStudy\Study\Model\User;
use PHPUnitStudy\Study\Services\Appraiser;

class AppraiserTest extends TestCase
{
    public function createAuctionInAscendingOrder(): array
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
        $auction->addBid(new Bid($ana, $highestBidValue1));
        $auction->addBid(new Bid($maria, $highestBidValue2));

        return [[$auction]];
    }

    public function createAuctionInDescendingOrder(): array
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
        $auction->addBid(new Bid($ana, 2000));
        $auction->addBid(new Bid($joao, 1000));

        return [[$auction]];
    }

    public function createAuctionInRandomOrder(): array
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

        return [[$auction]];
    }

    /**
     * @dataProvider createAuctionInAscendingOrder
     * @dataProvider createAuctionInDescendingOrder
     * @dataProvider createAuctionInRandomOrder
     */
    public function testAppraiserShouldGetHighestBidFromAuction(Auction $auction): void
    {      
        //! Act
        $appraiser = new Appraiser();
        $appraiser->evaluate($auction);

        //! Assert
        $highestBidValue = 4600;
        self::assertEquals($highestBidValue, $appraiser->getHighestBid()->getValue());
    }

    /**
     * @dataProvider createAuctionInAscendingOrder
     * @dataProvider createAuctionInDescendingOrder
     * @dataProvider createAuctionInRandomOrder
     */
    public function testAppraiserShouldGetThreeHighestBidsFromAuction(Auction $auction): void
    {        
        //! Act
        $appraiser = new Appraiser();
        $appraiser->evaluate($auction);
        
        //! Assert
        $highestBidValue1 = 4600;
        $highestBidValue2 = 4000;
        $highestBidValue3 = 3800;
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
