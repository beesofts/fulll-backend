<?php

namespace App\Tests\Domain\Model;

use App\App\Exception\VehicleAlreadyRegisteredException;
use App\Domain\Model\Fleet;
use App\Domain\Model\Vehicle;
use App\Tests\Builder\FleetBuilder;
use App\Tests\Builder\VehicleBuilder;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Fleet::class)]
class FleetTest extends TestCase
{
    public function testRegisterVehicle(): void
    {
        $fleet = FleetBuilder::new()->create();
        $fleet->registerVehicle(new Vehicle('1234'));

        self::assertCount(1, $fleet->getVehicles());
        self::assertEquals('1234', $fleet->getVehicles()[0]->getPlateNumber());
    }

    public function testRegisterTwiceVehicleThrowsAnException(): void
    {
        $this->expectException(VehicleAlreadyRegisteredException::class);

        $fleet = FleetBuilder::new()->create();

        $fleet->registerVehicle(new Vehicle('1234'));
        $fleet->registerVehicle(new Vehicle('1234'));
    }

    public function testHasVehicle(): void
    {
        $fleet = FleetBuilder::new()
            ->withVehicle(VehicleBuilder::new()->withPlateNumber('1234')->create())
            ->create()
        ;

        self::assertTrue($fleet->hasVehicle('1234'));
        self::assertFalse($fleet->hasVehicle('5678'));
    }
}
