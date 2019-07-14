<?php

namespace App\Service;

use App\Repository\TargetRepository;

class RuleService
{
    /**
     * @var TargetRepository
     */
    private $targetRepository;

    /**
     * RuleService constructor.
     *
     * @param TargetRepository $targetRepository
     */
    public function __construct(TargetRepository $targetRepository)
    {
        $this->targetRepository = $targetRepository;
    }

    /**
     * @param string $targetValue
     * @param object $object
     *
     * @return bool
     */
    public function evaluate(string $targetValue, $object): bool
    {
        if (!$target = $this->targetRepository->findOneByValue($targetValue)) {
            return false;
        }
        foreach ($target->getRuleSets() as $ruleSet) {
            if ($ruleSet->evaluate($object)) {
                $ruleSet->applyAction($object);

                if ($ruleSet->isStopProcessing()) {
                    return true;
                }
            }
        }

        return false;
    }
}
