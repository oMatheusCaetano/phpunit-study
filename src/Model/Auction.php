<?php

declare(strict_types=1);

namespace PHPUnitStudy\Study\Model;

use PHPUnitStudy\Study\Exceptions\ConsecutiveBidsException;

class Auction
{
    private int $id;

    /** @var array<Bid> $bids */
    private array $bids;
    private string $description;
    private \DateTimeInterface $startDate;
    private bool $finished;

    public function __construct(string $description)
    {
        $this->setDescription($description);
        $this->setFinished(false);
        $this->setBids([]);
    }

    public function addBid(Bid $bid): self
    {
        if ($this->isUserOfTheLastAddedBid($bid->getUser())) {
            throw new ConsecutiveBidsException(
                'Same user can not throw consecutives bids.'
            );
        }

        array_push($this->bids, $bid);
        return $this;
    }

    public function hasMoreThanDays(int $quantityOfDays): bool
    {
        $today = new \DateTime();
        $gap = $this->dataInicio->diff($today);

        return $gap->days > $quantityOfDays;
    }
    
    //*------- GETTERS AND SETTERS -------*//
    public function getId(): int
    {
        return $this->id;
    }

    /** @return array<Bid> */
    public function getBids(): array
    {
        return $this->bids;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStartDate(): \DateTimeInterface
    {
        return $this->startDate;
    }

    public function isFinished(): bool
    {
        return $this->finished;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /** @param array<Bid> $bids */
    public function setBids(array $bids): self
    {
        $this->bids = $bids;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setStartdate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function setFinished(bool $finished): self
    {
        $this->finished = $finished;
        return $this;
    }

    private function isUserOfTheLastAddedBid(User $user): bool
    {
        if (empty($this->bids)) {
            return false;
        }

        $lastAddedBid = $this->bids[array_key_last($this->bids)];
        if ($user !== $lastAddedBid->getUser()) {
            return false;
        }

        return true;
    }
}
