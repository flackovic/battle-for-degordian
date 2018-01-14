<?php
namespace App\Logic;

use App\Logic\Combat;
use App\Entity\Army;

class Battle
{

	protected $turn;
    protected $winner;

    protected $armies;
    protected $attacker;
    protected $defender;

	public function __construct(Army $army1, Army $army2)
	{
		$this->turn = 0;
        $this->armies[$army1->name] = $army1;
        $this->armies[$army2->name] = $army2;
	}

	public function start()
	{
		while($this->armies['Army1']->isAlive() && $this->armies['Army2']->isAlive())
        {
            $this->doTurn();
        }

        return ['winner' => $this->getWinner(), 'totalTurns' => $this->turn];

	}

    protected function doTurn()
	{
        // Draw random attacker and defender from opposite armies
        $this->chooseAttackerAndDefender();

        // Get unpredictable performance factors
        $this->includeRandomPerformanceFactors();

        // Deal damage
        $this->attack();

        // Remove corpses if someone died :)
        $this->checkForCasualties();

        $this->turn++;
	}

    /**
     * Extract keys from array of armies in tmp array and shuffle
     * to generate "randomness" in who attacks who.
     */
    protected function chooseAttackerAndDefender()
    {
        $armiesKeys = array_keys($this->armies);
        shuffle($armiesKeys);

        $attackingArmyKey = array_pop($armiesKeys);
        $defendingArmyKey = array_pop($armiesKeys);

        $this->attacker = $this->armies[$attackingArmyKey]->getRandomUnit();
        $this->defender = $this->armies[$defendingArmyKey]->getRandomUnit();
    }

    protected function includeRandomPerformanceFactors()
    {
        /**
         * If attacker is half the size of defender - he gets frightened and consequently his chance
         * to miss increases permanently
         */
        if($this->attacker->getHealth() < ($this->defender->getHealth() / 2))
        {
            $this->attacker->missPercent++;
        }
    }

    protected function attack()
    {
        $this->defender->health -= $this->attacker->miss() ? 0 : $this->attacker->getDamage() - $this->defender->getArmour();
    }

    /**
     * Unset units with health <= 0, as they are considered dead
     */
    protected function checkForCasualties()
    {
        if($this->attacker->getHealth() <= 0) {
            $this->armies[$this->attacker->armyName]->removeUnit($this->attacker);
        }

        if($this->defender->getHealth() <= 0) {
            $this->armies[$this->defender->armyName]->removeUnit($this->defender);
        }
    }

    /**
     * This assumes that we have only 1 winner and will return first army alive.
     */
    protected function getWinner()
    {
        foreach($this->armies as $army)
        {
            if($army->isAlive())
            {
                return $army;
            }
        }
    }
}
