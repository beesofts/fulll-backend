<?php

namespace App\Infra\Command\Fleet;

use App\App\Query\GetFleetsQuery;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:fleet:list',
)]
class ListCommand extends Command
{
    public function __construct(
        private readonly GetFleetsQuery $getFleetsQuery,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $table = new Table($io);
        $table->setHeaders(['Id', 'Owner']);
        foreach (($this->getFleetsQuery)() as $fleet) {
            $table->addRow([
                $fleet->getId(),
                $fleet->getOwner()->getName(),
            ]);
        }
        $table->render();
        $io->writeln('');

        return Command::SUCCESS;
    }
}
