<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RuleRepository")
 */
class Rule
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Target", inversedBy="rules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $target;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Algorithm", inversedBy="rules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $algorithm;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\RuleSet", mappedBy="rules")
     */
    private $ruleSets;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Condition", inversedBy="rules")
     */
    private $conditions;

    public function __construct()
    {
        $this->ruleSets = new ArrayCollection();
        $this->conditions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTarget(): ?Target
    {
        return $this->target;
    }

    public function setTarget(Target $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function getAlgorithm(): ?Algorithm
    {
        return $this->algorithm;
    }

    public function setAlgorithm(Algorithm $algorithm): self
    {
        $this->algorithm = $algorithm;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|RuleSet[]
     */
    public function getRuleSets(): Collection
    {
        return $this->ruleSets;
    }

    public function addRuleSet(RuleSet $ruleSet): self
    {
        if (!$this->ruleSets->contains($ruleSet)) {
            $this->ruleSets[] = $ruleSet;
            $ruleSet->addRule($this);
        }

        return $this;
    }

    public function removeRuleSet(RuleSet $ruleSet): self
    {
        if ($this->ruleSets->contains($ruleSet)) {
            $this->ruleSets->removeElement($ruleSet);
            $ruleSet->removeRule($this);
        }

        return $this;
    }

    /**
     * @return Collection|Condition[]
     */
    public function getConditions(): Collection
    {
        return $this->conditions;
    }

    public function addCondition(Condition $condition): self
    {
        if (!$this->conditions->contains($condition)) {
            $this->conditions[] = $condition;
        }

        return $this;
    }

    public function removeCondition(Condition $condition): self
    {
        if ($this->conditions->contains($condition)) {
            $this->conditions->removeElement($condition);
        }

        return $this;
    }

    public function evaluate($object): bool
    {
        $results = [];
        foreach ($this->getConditions() as $condition) {
            $results[] = $condition->evaluate($object);
        }

        return $this->getAlgorithm()->evaluate($results);
    }
}
