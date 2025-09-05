<?php

namespace App\Infra\Command\User;

use App\App\Command\CreateUserCommand;
use App\App\Command\CreateUserCommandHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:user:create',
)]
class CreateCommand extends Command
{
    public function __construct(
        private readonly CreateUserCommandHandler $createUserCommandHandler,
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('userName', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $userName = $input->getArgument('userName');
        $command = new CreateUserCommand($userName);
        ($this->createUserCommandHandler)($command);

        $io->success(sprintf('User %s created', $userName));

        return Command::SUCCESS;
    }
}
