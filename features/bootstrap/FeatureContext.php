<?php

use App\App\Command\ParkVehicleCommand;
use App\App\Command\ParkVehicleCommandHandler;
use App\App\Command\RegisterVehicleCommand;
use App\App\Command\RegisterVehicleCommandHandler;
use App\App\Exception\VehicleAlreadyRegisteredException;
use App\Domain\Model\Fleet;
use App\Domain\Model\User;
use App\Domain\Model\Vehicle;
use App\Domain\ValueObject\Location;
use App\Infra\Repository\FleetRepository;
use App\Infra\Repository\VehicleRepository;
use App\Shared\IdGenerator;
use Behat\Behat\Context\Context;
use Behat\Step\Given;
use Behat\Step\Then;
use Behat\Step\When;
use PHPUnit\Framework\Assert;

class FeatureContext implements Context
{
    private ?User $user = null;

    private ?Vehicle $myVehicle = null;

    private ?Fleet $myFleet = null;

    private ?Fleet $anotherFleet = null;

    private ?Location $location = null;

    private FleetRepository $fleetRepository;

    private VehicleRepository $vehicleRepository;

    private \Exception|null $lastError = null;

    public function __construct()
    {
        $this->fleetRepository = new FleetRepository();
        $this->vehicleRepository = new VehicleRepository();

        $this->user = new User('Current User');
    }

    #[Given('my fleet')]
    public function givenMyFleet(): void
    {
        $this->myFleet = new Fleet(IdGenerator::generate(), $this->user);
        $this->fleetRepository->save($this->myFleet);
    }

    #[Given('a vehicle')]
    public function givenAVehicle(): void
    {
        $this->myVehicle = new Vehicle(IdGenerator::generate());
        $this->vehicleRepository->save($this->myVehicle);
    }

    #[Given('I have registered this vehicle into my fleet')]
    public function iHaveRegisteredThisVehicleIntoMyFleet(): void
    {
        $this->myFleet->registerVehicle($this->myVehicle);
    }

    #[Given('the fleet of another user')]
    public function theFleetOfAnotherUser(): void
    {
        $this->anotherFleet = new Fleet(IdGenerator::generate(), new User('Another User'));
        $this->fleetRepository->save($this->anotherFleet);
    }

    #[Given('this vehicle has been registered into the other user\'s fleet')]
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet(): void
    {
        $this->anotherFleet->registerVehicle($this->myVehicle);
    }

    #[Given('a location')]
    public function aLocation(): void
    {
        $this->location = new Location(10, 10);
    }

    #[Given('my vehicle has been parked into this location')]
    public function myVehicleHasBeenParkedIntoThisLocation(): void
    {
        $this->myVehicle->setLocation($this->location);
        $this->vehicleRepository->save($this->myVehicle);
    }

    #[When('I register this vehicle into my fleet')]
    public function iRegisterThisVehicleIntoMyFleet(): void
    {
        $command = new RegisterVehicleCommand($this->myFleet?->getId(), $this->myVehicle?->getplateNumber());
        $handler = new RegisterVehicleCommandHandler($this->vehicleRepository, $this->fleetRepository);
        $handler($command);
    }

    #[When('I try to register this vehicle into my fleet')]
    public function iTryToRegisterThisVehicleIntoMyFleet(): void
    {
        try {
            $command = new RegisterVehicleCommand($this->myFleet?->getId(), $this->myVehicle?->getplateNumber());
            $handler = new RegisterVehicleCommandHandler($this->vehicleRepository, $this->fleetRepository);
            $handler($command);
        }
        catch (\Exception $exception) {
            $this->lastError = $exception;
        }
    }

    #[When('I park my vehicle at this location')]
    public function iParkMyVehicleAtThisLocation(): void
    {
        $command = new ParkVehicleCommand($this->myVehicle->getPlateNumber(), $this->location->getLatitude(), $this->location->getLongitude());
        $handler = new ParkVehicleCommandHandler($this->vehicleRepository);
        $handler($command);
        $this->myVehicle->setLocation($this->location);
    }

    #[When('I try to park my vehicle at this location')]
    public function iTryToParkMyVehicleAtThisLocation(): void
    {
        try {
            $command = new ParkVehicleCommand($this->myVehicle->getPlateNumber(), $this->location->getLatitude(), $this->location->getLongitude());
            $handler = new ParkVehicleCommandHandler($this->vehicleRepository);
            $handler($command);
            $this->myVehicle->setLocation($this->location);
        }
        catch (\Exception $exception) {
            $this->lastError = $exception;
        }
    }

    #[Then('this vehicle should be part of my vehicle fleet')]
    public function thisVehicleShouldBePartOfMyVehicleFleet(): void
    {
        $this->lastError = null;
        Assert::assertTrue($this->myFleet->hasVehicle($this->myVehicle->getPlateNumber()));
    }

    #[Then('I should be informed that this vehicle has already been registered into my fleet')]
    public function iShouldBeInformedThatThisVehicleHasBeenRegisteredIntoMyFleet(): void
    {
        Assert::assertInstanceOf(VehicleAlreadyRegisteredException::class, $this->lastError);
    }


    #[Then('the known location of my vehicle should verify this location')]
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation(): void
    {
        Assert::assertEquals($this->location->getLatitude(), $this->myVehicle->getLocation()->getLatitude());;
        Assert::assertEquals($this->location->getLongitude(), $this->myVehicle->getLocation()->getLongitude());;
    }

    #[Then('I should be informed that my vehicle is already parked at this location')]
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation(): void
    {
        Assert::assertInstanceOf(\App\App\Exception\VehicleAlreadyParkedAtThisLocation::class, $this->lastError);
    }
}
