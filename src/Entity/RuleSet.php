<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RuleSetRepository")
 */
class RuleSet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Target", inversedBy="ruleSets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $target;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Algorithm", inversedBy="ruleSets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $algorithm;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Rule", inversedBy="ruleSets")
     */
    private $rules;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Action", inversedBy="ruleSets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $action;

    /**
     * @ORM\Column(type="boolean")
     */
    private $stopProcessing = false;

    public function __construct()
    {
        $this->rules = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeRule(Rule $rule): self
    {
        if ($this->rules->contains($rule)) {
            $this->rules->removeElement($rule);
        }

        return $this;
    }

    public function getAction(): ?Action
    {
        return $this->action;
    }

    public function setAction(Action $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function evaluate($object): bool
    {
        $results = [];
        foreach ($this->getRules() as $rule) {
            $results[] = $rule->evaluate($object);
        }

        return $this->getAlgorithm()->evaluate($results);
    }

    public function applyAction($object): void
    {
        $this->getAction()->apply($object);
    }

    public function isStopProcessing(): bool
    {
        return $this->stopProcessing;
    }

    public function setStopProcessing(bool $stopProcessing): self
    {
        $this->stopProcessing = $stopProcessing;

        return $this;
    }
}
