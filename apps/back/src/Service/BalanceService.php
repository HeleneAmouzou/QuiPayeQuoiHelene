<?php

namespace App\Service;

use App\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;

class BalanceService
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function viewBalance (int $groupId): array
    {
        $groupRepository = $this->em->getRepository(Group::class);
        $group = $groupRepository->find(['id' => $groupId]);
        if ($group === null) {
            return [];
        }
        $members = $group->getMembers();
        $groupExpenses = $group->getExpensesOfTheGroup();
        $groupBalance = [];

        foreach ($groupExpenses as $groupExpense) {
            foreach ($members as $member) {
                if (!array_key_exists($member->getId(), $groupBalance)) {
                    $groupBalance[$member->getId()]=0;
                }
                $groupBalance [$member->getId()] += $groupExpense->getBalance($member);
            }
        }

        asort($groupBalance);

        foreach($groupBalance as $key => $memberBalance) {
            $currentMembers = array_values(array_filter($members->toArray(), fn($member) => $member->getId() === $key));
            if (empty($currentMembers)) {
                continue;
            }
            $currentMember = $currentMembers[0];
            $memberName = $currentMember->getName();
            $balances[$memberName] = $memberBalance;
        }

        return $balances;
    }
}
