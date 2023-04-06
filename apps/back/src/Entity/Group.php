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
#[Table(name:'`group`')]
class Group {
    #[Id]
    #[Column(type: Types::INTEGER)]
    #[GeneratedValue(strategy:'IDENTITY')]
    private int $id;

    #[Column(length: 140)]
    private string $name;

    #[ManyToMany(targetEntity: User::class, inversedBy:'groups')]
    private Collection $members;

    #[OneToMany(targetEntity: Expense::class, mappedBy:'group')]
    private Collection $expensesOfTheGroup;

    public function __construct(
        string $name,
        array $members,
        array $expensesOfTheGroup
    ) {
        $this->name = $name;
        $this->members = $members;
        $this->expensesOfTheGroup = $expensesOfTheGroup;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setMembers(array $members): void
    {
        $this->members = $members;
    }

    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function setExpensesOfTheGroup(array $expensesOfTheGroup): void
    {
        $this->expensesOfTheGroup = $expensesOfTheGroup;
    }

    public function getExpensesOfTheGroup(): Collection
    {
        return $this->expensesOfTheGroup;
    }
}
