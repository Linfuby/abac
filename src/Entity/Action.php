<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActionRepository")
 */
class Action
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
    private $applyTo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $discount;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RuleSet", mappedBy="action")
     */
    private $ruleSets;

    public function __construct()
    {
        $this->ruleSets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApplyTo(): ?string
    {
        return $this->applyTo;
    }

    public function setApplyTo(string $applyTo): self
    {
        $this->applyTo = $applyTo;

        return $this;
    }

    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    public function setDiscount(string $discount): self
    {
        $this->discount = $discount;

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
            $ruleSet->setAction($this);
        }

        return $this;
    }

    public function removeRuleSet(RuleSet $ruleSet): self
    {
        if ($this->ruleSets->contains($ruleSet)) {
            $this->ruleSets->removeElement($ruleSet);
            // set the owning side to null (unless already changed)
            if ($ruleSet->getAction() === $this) {
                $ruleSet->setAction(null);
            }
        }

        return $this;
    }

    public function apply($object): void
    {
        $discount = $this->getDiscount();
        $object->discount = $discount;
        switch ($this->getApplyTo()) {
            case 'by_percent':
                $object->price = $object->price * (100 - $discount) / 100;
                break;
            case 'by_fixed':
                $object->price -= $discount;
                break;
            case 'to_percent':
                $object->price = $object->price * ($discount / 100);
                break;
            case 'to_fixed':
                $object->price = $discount;
                break;
            default:
                break;
        }
    }
}
