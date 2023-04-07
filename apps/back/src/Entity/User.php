<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
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

    #[ManyToMany(targetEntity: Expense::class, mappedBy:'participants')]
    private Collection $expensesAsParticipant;

    #[OneToMany(targetEntity: Expense::class, mappedBy:'payer')]
    private Collection $expensesAsPayer;

    #[ManyToMany(targetEntity: Group::class, mappedBy:'members')]
    private Collection $groups;

    public function __construct(
        string $name,
        string $surname,
        string $mail,
        Collection $expensesAsParticipant,
        Collection $expensesAsPayer,
        Collection $groups
    ) {
        $this->name = $name;
        $this->surname = $surname;
        $this->mail = $mail;
        $this->expensesAsParticipant = $expensesAsParticipant;
        $this->expensesAsPayer = $expensesAsPayer;
        $this->groups = $groups;
    }

    public function getId(): int
        {
            return $this->id;
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

    public function setExpensesAsParticipant(Collection $expensesAsParticipant): void
    {
        $this->expensesAsParticipant = $expensesAsParticipant;
    }

    public function getExpensesAsParticipant(): Collection
    {
        return $this->expensesAsParticipant;
    }

    public function setExpensesAsPayer(Collection $expensesAsPayer): void
    {
        $this->expensesAsPayer = $expensesAsPayer;
    }

    public function getExpensesAsPayer(): Collection
    {
        return $this->expensesAsPayer;
    }

    public function setGroups(Collection $groups): void
    {
        $this->groups = $groups;
    }

    public function getGroups(): Collection
    {
        return $this->groups;
    }
}
