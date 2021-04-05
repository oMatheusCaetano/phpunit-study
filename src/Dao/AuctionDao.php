<?php

namespace PHPUnitStudy\Study\Dao;

use PHPUnitStudy\Study\Infra\ConnectionCreator;
use PHPUnitStudy\Study\Model\Auction;

class AuctionDao
{
    private \PDO $connection;

    public function __construct()
    {
        $this->setConnection(ConnectionCreator::getConnection());
    }

    public function create(Auction $auction): bool
    {
        $sql = 'INSERT INTO leiloes (descricao, finalizado, dataInicio) VALUES (?, ?, ?)';
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(1, $auction->getDescription(), \PDO::PARAM_STR);
        $statement->bindValue(2, $auction->isFinished(), \PDO::PARAM_BOOL);
        $statement->bindValue(3, $auction->getStartDate()->format('Y-m-d'));
        return $statement->execute();
    }

    /** @return array<Auction> */
    public function findByFinished(bool $finished): array
    {
        $sql = 'SELECT * FROM leiloes WHERE finalizado = ' . ($finished ? 1 : 0);
        $data = $this->connection->query($sql, \PDO::FETCH_ASSOC)->fetchAll();

        $auctions = [];
        foreach ($data as $item) {
            $auction = (new Auction(
                $item['descricao'], 
                new \DateTimeImmutable($item['dataInicio']), $item['id']
            ))->setFinished($item['finalizado']);

            $auctions[] = $auction;
        }

        return $auctions;
    }

    public function update(Auction $auction): bool
    {
        $sql = 'UPDATE leiloes SET descricao = :description, dataInicio = :startDate, finalizado = :finished WHERE id = :id';
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':description', $auction->getDescription());
        $statement->bindValue(':startDate', $auction->getStartDate()->format('Y-m-d'));
        $statement->bindValue(':finished', $auction->isFinished(), \PDO::PARAM_BOOL);
        $statement->bindValue(':id', $auction->getId(), \PDO::PARAM_INT);
        return $statement->execute();
    }

    //**------- GETTERS AND SETTERS -------*//
    public function getConnection(): \PDO
    {
        return $this->connection;
    }

    public function setConnection(\PDO $connection): self
    {
        $this->connection = $connection;
        return $this;
    }
}
