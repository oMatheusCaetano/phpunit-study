<?php

declare(strict_types=1);

namespace PHPUnitStudy\Study\Model;

class User
{
    private string $name;

    public function __construct(string $name)
    {
        $this->setName($name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}
