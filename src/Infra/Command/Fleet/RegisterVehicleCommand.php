<?php

namespace App\Infra\Command\Fleet;

use App\App\Command\RegisterVehicleCommandHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:fleet:register-vehicle',
)]
class RegisterVehicleCommand extends Command
{
    public function __construct(
        private readonly RegisterVehicleCommandHandler $registerVehicleCommandHandler,
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->addArgument('fleetId', InputArgument::REQUIRED)
            ->addArgument('plateNumber', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $fleetId = $input->getArgument('fleetId');
        $plateNumber = $input->getArgument('plateNumber');

        $command = new \App\App\Command\RegisterVehicleCommand($fleetId, $plateNumber);
        ($this->registerVehicleCommandHandler)($command);

        $io->success('Vehicle registered');

        return Command::SUCCESS;
    }
}
