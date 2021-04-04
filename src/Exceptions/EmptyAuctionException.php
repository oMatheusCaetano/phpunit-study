<?php

namespace PHPUnitStudy\Study\Exceptions;

class EmptyAuctionException extends \Exception
{
    public function __construct(string $message = '', int $code = 0)
    {
        parent::__construct($message, $code);
    }

    public function __toString(): string
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}" . PHP_EOL;
    }
}
