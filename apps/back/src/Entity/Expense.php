<?php

namespace App\Entity;

use App\Exception\ExpenseWithoutParticipantsException;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'expense')]
class Expense {
    #[Id]
    #[Column(type: Types::INTEGER)]
    #[GeneratedValue(strategy:'IDENTITY')]
    private int $id;

    public function __construct(

        #[Column(length: 140)]
        private string $name,

        #[Column(type: Types::DATETIME_IMMUTABLE)]
        private \DateTimeImmutable $date,

        #[Column(type: Types::INTEGER)]
        private int $amount,

        #[ManyToMany(targetEntity: User::class, inversedBy:'expensesAsParticipant')]
        #[JoinTable(name: 'users_expenses_as_participant')]
        private Collection $participants,

        #[ManyToOne(targetEntity: User::class, inversedBy: 'expensesAsPayer')]
        #[JoinColumn(name: 'payer_id', referencedColumnName: 'id')]
        private User $payer,

        #[ManyToOne(targetEntity: Group::class, inversedBy: 'expensesOfTheGroup')]
        #[JoinColumn(name: 'group_id', referencedColumnName: 'id')]
        private Group $group
    ) {
        if ($participants->isEmpty()) {
            throw new ExpenseWithoutParticipantsException();
        }
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setDate(\DateTimeImmutable $date): void
    {
        $this->date = $date;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setParticipants(Collection $participants): void
    {
        $this->participants = $participants;
    }

    public function getParticipants(): Collection
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

    public function setGroup(Group $group): void
    {
        $this->group = $group;
    }

    public function getGroup(): Group
    {
        return $this->group;
    }

    public function getAmountPerParticipant(): int
    {
        $expenseAmount = $this->getAmount();
        $numberOfParticipants = $this->getParticipants()->count();
        if ($numberOfParticipants > 0) {
            return $expenseAmount / $numberOfParticipants;
        } else {
            throw new ExpenseWithoutParticipantsException();
        }
    }

    public function getBalance(User $user): int
    {
        $balance = 0;
        $expenseAmount = $this->getAmount();
        $amountPerParticipant = $this->getAmountPerParticipant();

        if ($user === $this->getPayer()) {
            $balance += $expenseAmount;
        }
        if ($this->getParticipants()->contains($user)) {
            $balance -= $amountPerParticipant;
        }

        return $balance;
    }
}
