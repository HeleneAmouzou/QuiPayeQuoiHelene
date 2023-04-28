<?php

namespace spec\App\Entity;

use App\Entity\Expense;
use App\Entity\Group;
use App\Entity\User;
use App\Exception\ExpenseWithoutParticipantsException;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;

class ExpenseSpec extends ObjectBehavior
{
    function let(User $payer, User $participant, Group $group)
    {
        $this->beConstructedWith(
            'dépense',
            new DateTimeImmutable(),
            3000,
            new ArrayCollection([$participant->getWrappedObject(), $payer->getWrappedObject()]),
            $payer,
            $group
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Expense::class);
    }

    function it_should_throw_exception_if_participant_empty(User $participant, User $payer, Group $group)
    {
        $this->beConstructedWith(
            'dépense',
            new DateTimeImmutable(),
            3000,
            new ArrayCollection([]),
            $payer,
            $group
        );

        $this->shouldThrow(ExpenseWithoutParticipantsException::class)->duringInstantiation();
    }

    function it_gets_amount_per_participant()
    {
        $this->getAmountPerParticipant()->shouldReturn(1500);
    }

    function it_should_throw_exception_if_number_of_participants_is_not_superior_to_0()
    {
        $this->setParticipants(new ArrayCollection());

        $this->shouldThrow(ExpenseWithoutParticipantsException::class)->during(
            'getAmountPerParticipant'
        );
    }

    function it_adds_expense_amount_and_it_subtracts_amount_per_participant_to_the_balance_if_user_is_payer_and_participant(User $payer)
    {
        $this->setPayer($payer);
        $this->getBalance($payer)->shouldReturn(1500);
    }

    function it_adds_expense_amount_to_the_balance_if_user_is_payer(User $user)
    {
        $this->setPayer($user);
        $this->getBalance($user)->shouldReturn(3000);
    }

    function it_subtracts_amount_per_participant_to_the_balance_if_user_is_participant(User $participant)
    {
        $this->getBalance($participant)->shouldReturn(-1500);
    }

    function it_does_not_update_the_balance_if_user_is_not_payer_or_participant(User $user)
    {
        $this->getBalance($user)->shouldReturn(0);
    }
}
