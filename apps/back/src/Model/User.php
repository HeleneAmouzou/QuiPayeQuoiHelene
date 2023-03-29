<?php

namespace App\Model;

class User {
    private string $name;
    private string $surname;
    private string $mail;
    private $expenses = [];

    public function __construct(string $name, string $surname, string $mail)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->mail = $mail;
    }

    public function setName(string $name): void
    {
        $this->name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setSurname(string $surname): void
    {
        $this->surname;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setMail(string $mail): void
    {
        $this->mail;
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
