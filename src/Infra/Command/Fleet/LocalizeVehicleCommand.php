<?php

namespace App\Infra\Command\Fleet;

use App\App\Command\ParkVehicleCommand;
use App\App\Command\ParkVehicleCommandHandler;
use App\App\Exception\EntityNotFoundException;
use App\App\Query\GetFleetQuery;
use App\Domain\Model\Fleet;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:fleet:localize-vehicle',
)]
class LocalizeVehicleCommand extends Command
{
    public function __construct(
        private readonly GetFleetQuery $getFleetQuery,
        private readonly ParkVehicleCommandHandler $parkVehicleCommandHandler,
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->addArgument('fleetId', InputArgument::REQUIRED)
            ->addArgument('plateNumber', InputArgument::REQUIRED)
            ->addArgument('latitude', InputArgument::REQUIRED)
            ->addArgument('longitude', InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $fleetId = $input->getArgument('fleetId');
        $plateNumber = $input->getArgument('plateNumber');
        $latitude = $input->getArgument('latitude');
        $longitude = $input->getArgument('longitude');

        if (!is_numeric($latitude) || !is_numeric($longitude)) {
            $io->error('Latitude and longitude must be numeric');

            return Command::FAILURE;
        }

        $latitude = (float) $latitude;
        $longitude = (float) $longitude;

        $fleet = $this->getFleetOrFail($fleetId);
        if (!$fleet->hasVehicle($plateNumber)) {
            $io->error(sprintf('The vehicle with plate "%s" is not part of the fleet "%s"', $plateNumber, $fleetId));

            return Command::FAILURE;
        }

        $command = new ParkVehicleCommand($plateNumber, $latitude, $longitude);
        ($this->parkVehicleCommandHandler)($command);

        $io->success('Vehicle parked');

        return Command::SUCCESS;
    }

    private function getFleetOrFail(string $fleetId): Fleet
    {
        $fleet = ($this->getFleetQuery)($fleetId);

        if (is_null($fleet)) {
            throw new EntityNotFoundException(Fleet::class, $fleetId);
        }

        return $fleet;
    }
}
