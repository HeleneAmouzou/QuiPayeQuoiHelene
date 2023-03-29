<?php

declare(strict_types=1);

namespace App\Command;

use App\Model\Expense as ModelExpense;
use App\Model\User as ModelUser;
use DateTime;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:viewBalance',
    description: 'ViewBalance command to display the balance of each user'
)]
class ViewBalanceCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //Users creation
        $andre = new ModelUser('Andre','Toto','andre@gmail.com');
        $caroline = new ModelUser('Caroline', 'Titi','caro@gmail.com');
        $benoit = new ModelUser('Benoit', 'Tutu', 'benoit@gmail.com');
        $users = []; 
        $users [] = $andre;
        $users [] = $caroline;
        $users [] = $benoit;
        
        //Expenses creation
        $expense1 = new ModelExpense('essence', new DateTime('20 march 2023'), 'plein d\'essence pour aller au match', 30, [$andre, $caroline, $benoit], $andre);
        $expense2 = new ModelExpense('souvenir', new DateTime('21 march 2023'), 'souvenir de notre tournoi à Caen', 20, [$andre, $benoit], $andre);
        $expense3 = new ModelExpense('bar', new DateTime('24 march 2023'), 'tournee', 15, [$caroline, $benoit], $caroline);
        $expense4 = new ModelExpense('Materiel', new DateTime('25 march 2023'), 'nouveau materiel', 60, [$andre, $caroline, $benoit], $benoit);
        $expenses = [];
        $expenses [] = $expense1;
        $expenses [] = $expense2;
        $expenses [] = $expense3;
        $expenses [] = $expense4;

        //Adding expenses to users
        $andre->addExpense($expense1);
        $andre->addExpense($expense2);
        $caroline->addExpense($expense3);
        $benoit->addExpense($expense4);

        //Balance
        foreach($users as $user)
        {
            $expensesPaidByUser = [];
            foreach($expenses as $expense)
            {
                if($expense->getPayer() == $user)
                {
                    $expensesPaidByUser [] = $expense->getAmount();
                }
            } 
            $sumExpensesPaidByUser = array_sum($expensesPaidByUser);

            $expensesIncludingUser = [];
            foreach($expenses as $expense)
            {
                if(in_array($user, ($expense->getParticipants())))
                {
                    $expensesIncludingUser [] = $expense->getAmount()/(count($expense->getParticipants()));
                }
            }
            $sumExpensesIncludingUser = array_sum($expensesIncludingUser);

            $balancePerUser = $sumExpensesPaidByUser - $sumExpensesIncludingUser;
            $output->writeln("{$user->getName()} {$balancePerUser}");
        }
        
        return Command::SUCCESS;
    }
}
