<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConditionRepository")
 * @ORM\Table(name="conditions")
 */
class Condition
{
    const TABLE_NAME = 'conditions';
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
    private $attribute;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Rule", mappedBy="conditions")
     */
    private $rules;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Operator", inversedBy="conditions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $operator;

    public function __construct()
    {
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

    public function getAttribute(): ?string
    {
        return $this->attribute;
    }

    public function setAttribute(string $attribute): self
    {
        $this->attribute = $attribute;

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
            $rule->addCondition($this);
        }

        return $this;
    }

    public function removeRule(Rule $rule): self
    {
        if ($this->rules->contains($rule)) {
            $this->rules->removeElement($rule);
            $rule->removeCondition($this);
        }

        return $this;
    }

    public function getOperator(): ?Operator
    {
        return $this->operator;
    }

    public function setOperator(Operator $operator): self
    {
        $this->operator = $operator;

        return $this;
    }

    public function evaluate($object): bool
    {
        list(, $field) = explode('.', $this->getAttribute());
        if (!isset($object->{$field})) {
            return false;
        }

        return $this->getOperator()->compare($object->{$field}, $this->getValue());
    }
}
