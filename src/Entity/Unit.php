<?php

namespace App\Entity;

class Unit
{
    public $armyName;
    public $class;
    public $health;
    protected $armour;
    protected $damage;
    public $missPercent;

    public function __construct($armyName, $class, $stats)
    {
        $this->armyName = $armyName;
        $this->class = $class;
        $this->health = $stats['health'];
        $this->armour = $stats['armour'];
        $this->damage = $stats['damage'];
        $this->missPercent = $stats['missPercent'];
    }

    public function getHealth()
    {
        return $this->health;
    }

    public function setHealth($health)
    {
        $this->health = $health;
    }

    public function getArmour()
    {
        return $this->armour;
    }

    public function getDamage()
    {
        return $this->damage;
    }

    public function miss()
    {
        return $this->missPercent >= rand(1, 100);
    }
}
