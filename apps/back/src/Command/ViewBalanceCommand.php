<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Group;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
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

    public function configure(): void
    {
        $this->addArgument('groupName', InputArgument::REQUIRED, 'nom du groupe');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $groupName = $input->getArgument('groupName');
        $groupRepository = $this->doctrine->getRepository(Group::class);
        $group = $groupRepository->findOneBy(['name' => $groupName]);
        if ($group === null) {
            return COMMAND::FAILURE;
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
                return COMMAND::FAILURE;
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

        foreach($groupBalance as $key => $memberBalance){
            $currentMembers = array_values(array_filter($members->toArray(), fn($member) => $member->getId() === $key));

            if (empty($currentMembers)) {
                continue;
            }

            $currentMember = $currentMembers[0];
            $memberName = $currentMember->getName();

            $output->writeln("{$memberName} {$memberBalance}");
        }

        return Command::SUCCESS;
    }
}
