<?php

namespace App\Model;

class User {
    private array $expenses = [];

    public function __construct(
        private string $name,
        private string $surname,
        private string $mail
    ) {
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    public function getMail(): string
    {
        return $this->mail;
    }
 
    public function addExpense(Expense $expense): void
    {
        $this->expenses[] = $expense;
    }
}
