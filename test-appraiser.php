<?php

use PHPUnitStudy\Study\Appraiser;
use PHPUnitStudy\Study\Model\Auction;
use PHPUnitStudy\Study\Model\Bid;
use PHPUnitStudy\Study\Model\User;

require 'vendor/autoload.php';

$auction = new Auction('Ferrai 1220 0 Km');

$maria = new User('Maria');
$joao = new User('João');

$auction->addBid(new Bid($joao, 2000));
$auction->addBid(new Bid($maria, 2500));

$appraiser = new Appraiser();
$appraiser->evaluate($auction);

echo 'O maior lançe do leilão é: ' . $appraiser->getHighestBid()->getValue() . PHP_EOL;
