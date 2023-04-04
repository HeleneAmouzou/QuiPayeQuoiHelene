<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'user')]
class User {
    #[Id]
    #[Column(type: Types::INTEGER)]
    #[GeneratedValue(strategy:'IDENTITY')]
    private int $id;

    #[Column(length: 140)]
    private string $name;

    #[Column(length: 140)]
    private string $surname;

    #[Column(length: 255)]
    private string $mail; 

    public function __construct(
        string $name,
        string $surname,
        string $mail
    ) {
        $this->name = $name;
        $this->surname = $surname;
        $this->mail = $mail;
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
}
