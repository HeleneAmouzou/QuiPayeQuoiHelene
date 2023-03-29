<?php

class User {
    private string $name;
    private string $surname;
    private string $mail;

    public function __construct(string $name, string $surname, string $mail)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->mail = $mail;
    }

    public function setName(string $name){
        $this->name;
    }

    public function getName(): string{
        return $this->name;
    }

    public function setSurname(string $surname){
        $this->surname;
    }

    public function getSurname(): string{
        return $this->surname;
    }

    public function setMail(string $mail){
        $this->mail;
    }

    public function getMail(): string{
        return $this->mail;
    }

    private $expenses = [];
    public function addExpense(Expense $expense) {
        $this->expenses[] = $expense;
    }
}