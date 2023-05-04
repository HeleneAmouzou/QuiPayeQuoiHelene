<?php

namespace spec\App\Entity;

use App\Entity\Expense;
use App\Entity\Group;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;

class UserSpec extends ObjectBehavior
{
    function let(
        Expense $expensesAsParticipant1,
        Expense $expensesAsParticipant2,
        Expense $expensesAsPayer1,
        Expense $expensesAsPayer2,
        Group $group1,
        Group $group2
    ){
        $this->beConstructedWith(
            'prenom',
            'nom',
            'prenom.nom@mail.com',
            new ArrayCollection([$expensesAsParticipant1->getWrappedObject(), $expensesAsParticipant2->getWrappedObject()]),
            new ArrayCollection([$expensesAsPayer1->getWrappedObject(), $expensesAsPayer2->getWrappedObject()]),
            new ArrayCollection([$group1->getWrappedObject(), $group2->getWrappedObject()])


        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(User::class);
    }

    function it_should_return_the_name_of_the_user()
    {
        $this->__toString()->shouldBe("prenom");
    }
}
