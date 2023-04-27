<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\BalanceService;
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
    public function __construct(private BalanceService $balanceService)
    {
        parent::__construct();
    }

    public function configure(): void
    {
        $this->addArgument('groupId', InputArgument::REQUIRED, 'id du groupe');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $groupId = $input->getArgument('groupId');

        $balance = $this->balanceService->viewBalance($groupId);

        foreach ($balance as $memberName => $memberBalance) {
            $output->writeln("{$memberName} {$memberBalance}");
        }

        return Command::SUCCESS;

    }
}
