<?php

namespace App\Service;

use App\Entity\Unit;

class UnitGenerator
{
    const BASE_HEALTH = 1000;
    const BASE_DAMAGE = 300;
    const BASE_ARMOUR = 10;
    const BASE_MISS = 2;

    private $classes;

    public function __construct()
    {
        // This should be loaded from DB / Config file
        $this->classes = [
            'TankWarrior' => [
                'healthModifier' => 1.8,
                'damageModifier' => 0.2,
                'armourModifier' => 1.2,
                'missModifier' => 1.0,
            ],
            'DamageWarrior' => [
                'healthModifier' => 0.8,
                'damageModifier' => 1.7,
                'armourModifier' => 1.0,
                'missModifier' => 1.0,
            ],
            'Mage' => [
                'healthModifier' => 0.2,
                'damageModifier' => 2.0,
                'armourModifier' => 0.0,
                'missModifier' => 1.0,
            ],
            'Archer' => [
                'healthModifier' => 1.0,
                'damageModifier' => 5.0,
                'armourModifier' => 1.0,
                'missModifier' => 10.0,
            ],
        ];
    }

    /**
     * Returns array of random units.
     */
    public function generateRandomUnits($armyName, $numberOfUnits)
    {
        $units = [];

        for ($i = 0; $i < $numberOfUnits; ++$i) {
            $className = $this->getRandomClass();
            $stats = $this->generateStatsFromClass($className);
            $units[] = new Unit($armyName, $className, $stats);
        }

        return $units;
    }

    /**
     * Gets random class and apply its modifiers to base stats.
     */
    protected function generateStatsFromClass($className)
    {
        $modifiers = $this->classes[$className];

        return [
            'health' => self::BASE_HEALTH * $modifiers['healthModifier'],
            'damage' => self::BASE_DAMAGE * $modifiers['damageModifier'],
            'armour' => self::BASE_ARMOUR * $modifiers['armourModifier'],
            'missPercent' => self::BASE_MISS * $modifiers['missModifier'],
        ];
    }

    protected function getRandomClass()
    {
        return array_rand($this->classes);
    }
}
