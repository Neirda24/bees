<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Bee
 *
 * @ORM\Table(name="bee")
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="bee_type", type="string")
 * @ORM\DiscriminatorMap({"QueenBee" = "QueenBee", "OtherBee" = "OtherBee"})
 */
abstract class Bee
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
     * @ORM\Column(name="max_lifespan", type="integer")
     */
    protected $maxLifespan;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="remaining_lifespan", type="integer", nullable=true)
     */
    protected $remainingLifespan = null;

    /**
     * @var integer
     *
     * @ORM\Column(name="hit_damages", type="integer")
     */
    protected $hitDamages;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

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
     * Set max lifespan
     *
     * @param integer $maxLifespan
     *
     * @return $this
     */
    public function setMaxLifespan($maxLifespan)
    {
        $this->maxLifespan = $maxLifespan;

        return $this;
    }

    /**
     * Get max lifespan
     *
     * @return integer
     */
    public function getMaxLifespan()
    {
        return $this->maxLifespan;
    }

    /**
     * Get Remaining Lifespan
     *
     * @return int
     */
    public function getRemainingLifespan()
    {
        if (null === $this->remainingLifespan) {
            $this->remainingLifespan = $this->maxLifespan;
        }
        return $this->remainingLifespan;
    }

    /**
     * Set Remaining Lifespan
     *
     * @param int $remainingLifespan
     *
     * @return $this
     */
    public function setRemainingLifespan($remainingLifespan)
    {
        $this->remainingLifespan = (int)$remainingLifespan;

        return $this;
    }

    /**
     * Set hitDamages
     *
     * @param integer $hitDamages
     *
     * @return $this
     */
    public function setHitDamages($hitDamages)
    {
        $this->hitDamages = $hitDamages;

        return $this;
    }

    /**
     * Get hitDamages
     *
     * @return integer
     */
    public function getHitDamages()
    {
        return $this->hitDamages;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Apply damages to the current bee
     *
     * @return $this
     */
    public function hit()
    {
        $this->remainingLifespan = $this->getRemainingLifespan() - $this->getHitDamages();

        return $this;
    }

    /**
     * Return rather or not the current bee is dead.
     *
     * @return bool
     */
    public function isDead()
    {
        return ($this->getRemainingLifespan() <= 0);
    }
}

