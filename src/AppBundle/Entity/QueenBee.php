<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * QueenBee
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QueenBeeRepository")
 */
class QueenBee extends Bee
{
    /**
     * @var OtherBee[]
     *
     * @ORM\OneToMany(targetEntity="OtherBee", mappedBy="queenBee")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $otherBees;

    /**
     * Get OtherBees
     *
     * @return OtherBee[]
     */
    public function getOtherBees()
    {
        return $this->otherBees;
    }

    /**
     * Set OtherBees
     *
     * @param OtherBee[] $otherBees
     *
     * @return $this
     */
    public function setOtherBees(array $otherBees)
    {
        foreach ($otherBees as $otherBee) {
            $this->addOtherBee($otherBee);
        }

        return $this;
    }

    /**
     * @param OtherBee $otherBee
     *
     * @return $this
     */
    public function addOtherBee(OtherBee $otherBee)
    {
        if (!($this->otherBees instanceof OtherBee)) {
            $this->otherBees = new ArrayCollection();
        }

        $this->otherBees->add($otherBee);
        $otherBee->setQueenBee($this);

        return $this;
    }
}

