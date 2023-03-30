<?php

namespace App\Model;

class Expense {
    public function __construct(
        private string $name,
        private \DateTime $date,
        private string $description,
        private int $amount,
        private array $participants,
        private User $payer
    ) {
        $payer->addExpense($this);
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setParticipants(array $participants): void
    {
        $this->participants = $participants;
    }

    public function getParticipants(): array
    {
        return $this->participants;
    }

    public function setPayer(User $payer): void
    {
        $this->payer = $payer;
    }

    public function getPayer(): User
    {
        return $this->payer;
    }
}
