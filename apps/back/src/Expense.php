<?php

class Expense {
    private string $name;
    private \DateTime $date;
    private string $description;
    private int $amount;
    private array $participants;
    private User $payer;

    public function __construct(string $name, DateTime $date, string $description, int $amount, array $participants, User $payer)
    {
        $this->name = $name;
        $this->date = $date;
        $this->description = $description;
        $this->amount = $amount;
        $this->participants = $participants;
        $this->payer = $payer;
    }

    public function setName(string $name){
        $this->name;
    }

    public function getName(): string{
        return $this->name;
    }

    public function setDate(DateTime $date){
        $this->date;
    }

    public function getDate(): \DateTime{
        return $this->date;
    }

    public function setDescription(string $description){
        $this->description;
    }

    public function getDescription(): string{
        return $this->description;
    }

    public function setAmount(int $amount){
        $this->amount;
    }

    public function getAmount(): int{
        return $this->amount;
    }

    public function setParticipants(array $participants){
        $this->participants;
    }

    public function getParticipants(): array{
        return $this->participants;
    }

    public function setPayer(User $payer){
        $this->payer;
    }

    public function getPayer(): User{
        return $this->payer;
    }
}