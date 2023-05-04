<?php

namespace spec\App\Entity;

use App\Entity\Expense;
use App\Entity\Group;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;

class GroupSpec extends ObjectBehavior
{
    function let(User $user1, User $user2, Expense $expense1, Expense $expense2)
    {
        $this->beConstructedWith(
            'groupe',
            new ArrayCollection([$user1->getWrappedObject(), $user2->getWrappedObject()]),
            new ArrayCollection([$expense1->getWrappedObject(), $expense2->getWrappedObject()])
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Group::class);
    }

    function it_adds_members(User $user3)
    {
        $this->addMember($user3);
        $this->getMembers()->shouldHaveCount(3);
        $this->getMembers()->shouldContain($user3);
    }

    function it_should_return_the_name_of_the_group()
    {
        $this->__toString()->shouldBe("groupe");
    }
}
