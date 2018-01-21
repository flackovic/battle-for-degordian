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
            'missPercent' => 100,
        ];

        //$this->unit = new Unit($this->armyName, $this->class, $this->stats);
    }

    public function testUnitCanBeConstructed()
    {
        self::assertInstanceOf(Unit::class, $this->unit);
    }

    public function testAttributesAreSetOnConstruct()
    {
        self::assertSame($this->unit->getHealth(), $this->stats['health']);
        self::assertSame($this->unit->getDamage(), $this->stats['damage']);
        self::assertSame($this->unit->getArmour(), $this->stats['armour']);
        self::assertSame($this->unit->missPercent, $this->stats['missPercent']);
    }

    public function testItWillMissIfMissChanceIs100Percent()
    {
        $missed = $this->unit->miss();

        self::assertTrue($missed);
    }

    public function testItWillNotMissIfMissChanceIs0Percent()
    {
        $this->unit->missPercent = 0;

        $missed = $this->unit->miss();

        self::assertFalse($missed);
    }
}
