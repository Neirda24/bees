<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity
 */
class Game
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="number_round", type="integer")
     */
    protected $numberRound = 0;

    /**
     * @var QueenBee
     *
     * @ORM\ManyToOne(targetEntity="QueenBee")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $queenBee;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numberRound
     *
     * @param integer $numberRound
     *
     * @return Game
     */
    public function setNumberRound($numberRound)
    {
        $this->numberRound = $numberRound;

        return $this;
    }

    /**
     * Get numberRound
     *
     * @return integer
     */
    public function getNumberRound()
    {
        return $this->numberRound;
    }

    /**
     * @return $this
     */
    public function addNumberRound()
    {
        $this->numberRound++;

        return $this;
    }

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

