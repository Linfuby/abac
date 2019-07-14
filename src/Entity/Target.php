<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TargetRepository")
 */
class Target
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RuleSet", mappedBy="target")
     */
    private $ruleSets;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rule", mappedBy="target")
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

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
            $ruleSet->setTarget($this);
        }

        return $this;
    }

    public function removeRuleSet(RuleSet $ruleSet): self
    {
        if ($this->ruleSets->contains($ruleSet)) {
            $this->ruleSets->removeElement($ruleSet);
            // set the owning side to null (unless already changed)
            if ($ruleSet->getTarget() === $this) {
                $ruleSet->setTarget(null);
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
            $rule->setTarget($this);
        }

        return $this;
    }

    public function removeRule(Rule $rule): self
    {
        if ($this->rules->contains($rule)) {
            $this->rules->removeElement($rule);
            // set the owning side to null (unless already changed)
            if ($rule->getTarget() === $this) {
                $rule->setTarget(null);
            }
        }

        return $this;
    }
}
