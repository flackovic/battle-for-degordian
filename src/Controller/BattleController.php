<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Army;
use App\Logic\Battle;
use App\Service\UnitGenerator;
use App\Service\SimpleValidator;

class BattleController extends AbstractController
{
    public function index(Request $request, SimpleValidator $validator, UnitGenerator $generator)
    {
        $unitCountForArmy1 = $request->query->get('army1');
        $unitCountForArmy2 = $request->query->get('army2');

        // Simple validator to move logic from controller, in practice we should use Symfony's validation
        if (!$validator->validate([$unitCountForArmy1, $unitCountForArmy2])) {
            return $this->render('index.html.twig', ['error' => 'Please provide valid unit count for each army!']);
        }

        // Generate units
        $units1 = $generator->generateRandomUnits('Army1', $unitCountForArmy1);
        $units2 = $generator->generateRandomUnits('Army2', $unitCountForArmy2);

        // Create army
        $army1 = new Army('Army1', $units1);
        $army2 = new Army('Army2', $units2);

        // Battle
        $battle = new Battle($army1, $army2);
        $result = $battle->start();

        return $this->render('index.html.twig', ['winner' => $result['winner']->getName(), 'unitCount' => $result['winner']->getUnitCount(), 'turns' => $result['totalTurns']]);
    }
}
