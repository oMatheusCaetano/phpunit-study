<?php

namespace Alura\Leilao\Model;

class Bid
{
    private User $user;
    private float $value;

    public function __construct(User $user, float $value)
    {
        $this->setUser($user);
        $this->setValue($value);
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;
        return $this;
    }
}
