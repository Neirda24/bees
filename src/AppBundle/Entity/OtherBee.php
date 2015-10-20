<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OtherBee
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OtherBeeRepository")
 */
class OtherBee extends Bee
{
    /**
     * @var QueenBee
     *
     * @ORM\ManyToOne(targetEntity="QueenBee", inversedBy="otherBees")
     */
    protected $queenBee;

    /**
     * Get QueenBee
     *
     * @return QueenBee
     */
    public function getQueenBee()
    {
        return $this->queenBee;
    }

    /**
     * Set QueenBee
     *
     * @param QueenBee $queenBee
     *
     * @return $this
     */
    public function setQueenBee(QueenBee $queenBee)
    {
        $this->queenBee = $queenBee;

        return $this;
    }
}

