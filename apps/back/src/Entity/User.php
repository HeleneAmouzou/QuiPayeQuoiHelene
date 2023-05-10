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
use Symfony\Component\Security\Core\User\UserInterface;

#[Entity]
#[Table(name: 'user')]
class User implements UserInterface {
    #[Id]
    #[Column(type: Types::INTEGER)]
    #[GeneratedValue(strategy:'IDENTITY')]
    private int $id;

    public function __construct(
        #[Column(length: 140)]
        private string $name,

        #[Column(length: 140)]
        private string $surname,

        #[Column(length: 255)]
        private string $email,

        #[Column(type: Types::JSON)]
        private Collection $roles,

        #[Column(length: 15)]
        private ?string $password = null,

        #[ManyToMany(targetEntity: Expense::class, mappedBy:'participants')]
        private Collection $expensesAsParticipant,

        #[OneToMany(targetEntity: Expense::class, mappedBy:'payer')]
        private Collection $expensesAsPayer,

        #[ManyToMany(targetEntity: Group::class, mappedBy:'members')]
        private Collection $groups
    ) {
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

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getRoles(): array
    {
        // dump($this);
        // $roles = $this->roles;
        // $roles[] = 'ROLE_USER';
        return ['ROLE_USER'];
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function eraseCredentials()
    {
        $this->password = null;
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

    public function __toString()
    {
        return ($this->getName());
    }
}
