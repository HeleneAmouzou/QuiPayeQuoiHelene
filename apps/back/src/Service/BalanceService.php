<?php

namespace App\Service;

use App\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;

class BalanceService
{
    public function __construct(public EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function viewBalance (string $groupName): array
    {
        $groupRepository = $this->em->getRepository(Group::class);
        $group = $groupRepository->findOneBy(['name' => $groupName]);
        if ($group === null) {
            return [];
        }
        $members = $group->getMembers();
        $groupExpenses = $group->getExpensesOfTheGroup();
        $groupBalance = [];

        foreach ($groupExpenses as $groupExpense) {
            $payer = $groupExpense->getPayer();
            $expenseAmount = $groupExpense->getAmount();
            if (count($groupExpense->getParticipants()) > 0) {
                $amountPerParticipant = $expenseAmount/(count($groupExpense->getParticipants()));
            } else {
                return $groupBalance;
            }

           foreach ($members as $member) {
            if (!array_key_exists($member->getId(), $groupBalance)) {
                $groupBalance[$member->getId()]=0;
            }
                if ($member === $payer) {
                   $groupBalance[$member->getId()]+=$expenseAmount;
                }

                if (in_array($member,$groupExpense->getParticipants()->toArray())) {
                   $groupBalance[$member->getId()]-=$amountPerParticipant;
                }
             }
        }

        asort($groupBalance);

        foreach($groupBalance as $key => $memberBalance){
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
