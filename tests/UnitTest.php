<?php
namespace tests;

use App\Entity\Unit;
use PHPUnit\Framework\TestCase;

class UnitTest extends TestCase
{

    protected $armyName;
    protected $class;
    protected $stats;

    public function setUp()
    {
        $this->armyName = 'FakeArmyName';
        $this->class = 'FakeClassType';
        $this->stats = [
            'health' => 100,
            'damage' => 100,
            'armour' => 100,
            'missPercent' => 100
        ];
    }

    public function testUnitCanBeConstructed()
    {
        $unit = new Unit($this->armyName, $this->class, $this->stats);

        self::assertInstanceOf(Unit::class, $unit);
    }

    public function testItWillMissIfMissChanceIs100Percent()
    {
        $unit = new Unit($this->armyName, $this->class, $this->stats);

        $missed = $unit->miss();

        self::assertTrue($missed);
    }

    public function testItWillNotMissIfMissChanceIs0Percent()
    {
        $unit = new Unit($this->armyName, $this->class, $this->stats);

        $unit->missPercent = 0;

        $missed = $unit->miss();

        self::assertFalse($missed);
    }

}