<?php

declare(strict_types=1);

namespace App\Command;

use App\Model\Expense;
use App\Model\User;
use DateTime;
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
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $andre = new User('Andre','Toto','andre@gmail.com');
        $caroline = new User('Caroline', 'Titi','caro@gmail.com');
        $benoit = new User('Benoit', 'Tutu', 'benoit@gmail.com');
        $users = [$andre,$caroline,$benoit];
        
        $expense1 = new Expense('essence', new DateTime('20 march 2023'), 'plein d\'essence pour aller au match', 30, [$andre, $caroline, $benoit], $andre);
        $expense2 = new Expense('souvenir', new DateTime('21 march 2023'), 'souvenir de notre tournoi à Caen', 20, [$andre, $benoit], $andre);
        $expense3 = new Expense('bar', new DateTime('24 march 2023'), 'tournee', 15, [$caroline, $benoit], $caroline);
        $expense4 = new Expense('Materiel', new DateTime('25 march 2023'), 'nouveau materiel', 60, [$andre, $caroline, $benoit], $benoit);
        $expenses = [$expense1,$expense2,$expense3,$expense4];

        /* Balance : sum of everything a member paid for the group, 
        then sum of the transactions concerning a member 
        and finally calculate the difference between the two amounts */
        foreach($users as $user)
        {
            $expensesPaidByUser = [];
            $expensesIncludingUser = [];

            foreach($expenses as $expense)
            {
                if ($expense->getPayer() == $user)
                {
                    $expensesPaidByUser [] = $expense->getAmount();
                }
                
                if (in_array($user, ($expense->getParticipants())))
                {
                    $expensesIncludingUser [] = $expense->getAmount()/(count($expense->getParticipants()));
                }
            } 
            
            $sumExpensesPaidByUser = array_sum($expensesPaidByUser);
            $sumExpensesIncludingUser = array_sum($expensesIncludingUser);
            $balancePerUser = $sumExpensesPaidByUser - $sumExpensesIncludingUser;

            $output->writeln("{$user->getName()} {$balancePerUser}");
        }
        
        return Command::SUCCESS;
    }
}
