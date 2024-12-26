<?php

namespace App\Service;

use App\Entity\Formula;
use App\Repository\FormulaRepository;
use Doctrine\ORM\EntityManagerInterface;

class PositionService
{
    public function __construct(
        private EntityManagerInterface $em,
        private FormulaRepository $formulaRepository,
    )
    {
        
    }

    public function new(Formula $formula): int {
        (int)$new = 1;
        $maxResult = count($formula->getProject()->getFormulas());
        if($maxResult)
            $new = $maxResult + 1;
        return $new;
    }

    public function move(Formula $formula, int $direction = -1): bool {
        $currentPosition = $formula->getPosition();
        $targetPosition = $currentPosition + $direction;
        if ($targetPosition < 1)
            return false;
        $replacedElement = $this->formulaRepository->findOneBy([
            'project' => $formula->getProject(),
            'position' => $formula->getPosition(),
        ]);
        if (!$replacedElement)
            return false;
        $replacedElement->setPosition($currentPosition);
        $formula->setPosition($targetPosition);
        $this->em->flush();
        return true;
    }

    public function remove($formula): void {
        $again = $this->move($formula, 1);
        if($again)
            $this->remove($formula);
    }
}