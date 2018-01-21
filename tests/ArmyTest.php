<?php

namespace tests;

use App\Entity\Army;
use App\Entity\Unit;
use App\Service\UnitGenerator;
use PHPUnit\Framework\TestCase;

class ArmyTest extends TestCase
{
    protected $unitGenerator;
    protected $unitCount;
    protected $armyName;
    protected $units;
    protected $army;

    public function setUp()
    {
        $this->unitGenerator = new UnitGenerator();
        $this->unitCount = 10;
        $this->armyName = 'FakeArmyName';
        $this->units = $this->unitGenerator->generateRandomUnits($this->armyName, $this->unitCount);

        $this->army = new Army($this->armyName, $this->units);
    }

    public function testItCanBeConstructed()
    {
        self::assertInstanceOf(Army::class, $this->army);
    }

    public function testUnitCountWorks()
    {
        self::assertSame($this->army->getUnitCount(), $this->unitCount);
    }

    public function testIsAliveWorks()
    {
        self::assertTrue($this->army->isAlive());
    }

    public function testGetRandomUnitReturnsInstanceOfUnit()
    {
        $unit = $this->army->getRandomUnit();

        self::assertInstanceOf(Unit::class, $unit);
    }

    public function testRemoveUnitWorks()
    {
        $unit = $this->army->getRandomUnit();
        $this->army->removeUnit($unit);

        self::assertSame($this->army->getUnitCount(), $this->unitCount - 1);
    }

    public function testArmyCanDieIfNoUnitIsLeft()
    {
        for ($i = 0; $i < $this->unitCount; ++$i) {
            $unit = $this->army->getRandomUnit();
            $this->army->removeUnit($unit);
        }

        self::assertFalse($this->army->isAlive());
    }
}
