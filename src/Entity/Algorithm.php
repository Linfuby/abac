<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlgorithmRepository")
 */
class Algorithm
{
    const TABLE_NAME = 'algorithm';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RuleSet", mappedBy="algorithm")
     */
    private $ruleSets;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rule", mappedBy="algorithm")
     */
    private $rules;

    public function __construct()
    {
        $this->ruleSets = new ArrayCollection();
        $this->rules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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
            $ruleSet->setAlgorithm($this);
        }

        return $this;
    }

    public function removeRuleSet(RuleSet $ruleSet): self
    {
        if ($this->ruleSets->contains($ruleSet)) {
            $this->ruleSets->removeElement($ruleSet);
            // set the owning side to null (unless already changed)
            if ($ruleSet->getAlgorithm() === $this) {
                $ruleSet->setAlgorithm(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rule[]
     */
    public function getRules(): Collection
    {
        return $this->rules;
    }

    public function addRule(Rule $rule): self
    {
        if (!$this->rules->contains($rule)) {
            $this->rules[] = $rule;
            $rule->setAlgorithm($this);
        }

        return $this;
    }

    public function removeRule(Rule $rule): self
    {
        if ($this->rules->contains($rule)) {
            $this->rules->removeElement($rule);
            // set the owning side to null (unless already changed)
            if ($rule->getAlgorithm() === $this) {
                $rule->setAlgorithm(null);
            }
        }

        return $this;
    }

    public function evaluate(array $results): bool
    {
        $results = array_map('boolval', $results);
        switch ($this->getCode()) {
            default:
                return count($results) && !in_array(false, $results);
        }
    }
}
