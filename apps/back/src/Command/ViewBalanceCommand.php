<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Group;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:view-balance',
    description: 'ViewBalance command to display the balance of each user'
)]
class ViewBalanceCommand extends Command
{
    public function __construct(private ManagerRegistry $doctrine)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $groupRepository = $this->doctrine->getRepository(Group::class);
        $group = $groupRepository->findOneBy(['name' => 'bad']);
        if ($group === null) {
            return COMMAND::FAILURE;
        }
        $members = $group->getMembers();
        $groupExpenses = $group->getExpensesOfTheGroup();
        $groupBalance = [];

        foreach ($groupExpenses as $groupExpense) {
            $payer = $groupExpense->getPayer();
            $expenseAmount = $groupExpense->getAmount();
            $amountPerParticipant = $expenseAmount/(count($groupExpense->getParticipants()));
            if (count($groupExpense->getParticipants()) <= 0) {
                return COMMAND::FAILURE;
            }

           foreach ($members as $member) {
            if (!isset($groupBalance[$member->getId()])) {
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

        foreach($groupBalance as $key => $memberBalance){
            $currentMember = array_filter($members->toArray(), fn($member) => $member->getId() == $key);
            $memberName = array_pop($currentMember)->getName();
            $output->writeln("{$memberName} {$memberBalance}");
        }

        return Command::SUCCESS;
    }
}
