<?php
namespace App\Entity;

class Army
{
    public $name;
    public $units;

    public function __construct(String $name, Array $units)
    {
        $this->name = $name;
        $this->units = $units;
    }

    public function isAlive()
    {
        return count($this->units) > 0;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUnitcount()
    {
        return count($this->units);
    }

    public function getRandomUnit()
    {
        return $this->units[array_rand($this->units)];
    }

    public function updateUnit($unitKey, Unit $unit)
    {
        $this->units[$unitKey] = $unit;
    }

    public function removeUnit(Unit $unit)
    {
        $unitId = array_search($unit, $this->units);
        unset($this->units[$unitId]);
    }

}
