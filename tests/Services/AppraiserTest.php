<?php

namespace PHPUnitStudy\Study\Tests\Services;

use PHPUnit\Framework\TestCase;
use PHPUnitStudy\Study\Exceptions\EmptyAuctionException;
use PHPUnitStudy\Study\Exceptions\FinishedAuctionException;
use PHPUnitStudy\Study\Model\Auction;
use PHPUnitStudy\Study\Model\Bid;
use PHPUnitStudy\Study\Model\User;
use PHPUnitStudy\Study\Services\Appraiser;

class AppraiserTest extends TestCase
{
    private Appraiser $appraiser;

    //**------- SET UP -------**//
    public function setUp(): void
    {
        $this->appraiser = new Appraiser();
    }

    //**------- DATA PROVIDERS -------**//
    public function createAuctionWithBidsInAscendingOrder(): array
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

        return ['Auction with bids in ascending order' => [$auction]];
    }

    public function createAuctionWithBidsInDescendingOrder(): array
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

        return ['Auction with bids in descending order' => [$auction]];
    }

    public function createAuctionWithBidsInRandomOrder(): array
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
        $auction->addBid(new Bid($joao, 2000));
        $auction->addBid(new Bid($maria, 2150));
        $auction->addBid(new Bid($joao, $highestBidValue3));

        return ['Auction with bids in random order' => [$auction]];
    }

    //**------- TESTS -------**//
    /**
     * @dataProvider createAuctionWithBidsInAscendingOrder
     * @dataProvider createAuctionWithBidsInDescendingOrder
     * @dataProvider createAuctionWithBidsInRandomOrder
     */
    public function testAppraiserShouldGetHighestBidFromAuction(Auction $auction): void
    {      
        //* Act
        $this->appraiser->evaluate($auction);

        //* Assert
        $highestBidValue = 4600;
        self::assertEquals($highestBidValue, $this->appraiser->getHighestBid()->getValue());
    }

    /**
     * @dataProvider createAuctionWithBidsInAscendingOrder
     * @dataProvider createAuctionWithBidsInDescendingOrder
     * @dataProvider createAuctionWithBidsInRandomOrder
     */
    public function testAppraiserShouldGetThreeHighestBidsFromAuction(Auction $auction): void
    {        
        //* Act
        $this->appraiser->evaluate($auction);
        
        //* Assert
        $highestBidValue1 = 4600;
        $highestBidValue2 = 4000;
        $highestBidValue3 = 3800;
        self::assertCount(3, $this->appraiser->getThreeHighestBids());
        self::assertEquals(
            $highestBidValue1,
            $this->appraiser->getThreeHighestBids()[0]->getValue()
        );
        self::assertEquals(
            $highestBidValue2,
            $this->appraiser->getThreeHighestBids()[1]->getValue()
        );
        self::assertEquals(
            $highestBidValue3,
            $this->appraiser->getThreeHighestBids()[2]->getValue()
        );
    }

    public function testAuctionWithNoBidsCantBeEvaluated(): void
    {
        //* Arrange
        $auction = new Auction('Fiat 140 0Km');
        
        //* Assert
        $this->expectException(EmptyAuctionException::class);
        $this->expectExceptionMessage('Can not evaluate an auction with no bids.');

        //* Act
        $this->appraiser->evaluate($auction);
    }

    public function testAppraiserShouldNotEvaluateFinishedAuction(): void
    {
        //* Arrange
        $auction = new Auction('Fiat 140 0Km');

        //* Assert
        $this->expectException(FinishedAuctionException::class);
        $this->expectExceptionMessage('Can not evaluate an finished.');

        //* Act
        $auction->setFinished(true);
        $this->appraiser->evaluate($auction);
    }
}
