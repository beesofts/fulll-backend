<?php

namespace App\Infra\Command\Fleet;

use App\App\Command\CreateFleetCommand;
use App\App\Command\CreateFleetCommandHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:fleet:create',
)]
class CreateCommand extends Command
{
    public function __construct(
        private readonly CreateFleetCommandHandler $createFleetCommandHandler,
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->addArgument('userName', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $userName = $input->getArgument('userName');
        if (is_null($userName)) {
            $io->error('You must provide a user name');

            return Command::FAILURE;
        }

        $command = new CreateFleetCommand($userName);
        $fleetId = ($this->createFleetCommandHandler)($command);

        $io->success(sprintf('Fleet created with id %s', $fleetId));

        return Command::SUCCESS;
    }
}
