<?php

namespace App\Infra\Command\User;

use App\App\Query\GetUsersQuery;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:user:list',
)]
class ListCommand extends Command
{
    public function __construct(
        private readonly GetUsersQuery $getUsersQuery,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $table = new Table($io);
        $table->setHeaders(['Name']);
        foreach (($this->getUsersQuery)() as $user) {
            $table->addRow([
                $user->getName(),
            ]);
        }
        $table->render();
        $io->writeln('');

        return Command::SUCCESS;
    }
}
