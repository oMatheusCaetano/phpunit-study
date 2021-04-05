<?php

namespace PHPUnitStudy\Study\Service;

use PHPUnitStudy\Study\Dao\AuctionDao;

class AuctionFinisher
{
    public function finish()
    {
        $dao = new AuctionDao();
        $auctions = $dao->findByFinished(false);

        foreach ($auctions as $auction) {
            if ($auction->hasMoreThanDays(7)) {
                $auction->setFinished(true);
                $dao->update($auction);
            }
        }
    }
}
