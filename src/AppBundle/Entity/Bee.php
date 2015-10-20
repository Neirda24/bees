<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Bee
 *
 * @ORM\Table(name="bee")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BeeRepository")
 */
class Bee
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
     * @var Bee[]|null
     *
     * @ORM\OneToMany(targetEntity="Bee", mappedBy="parent")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $children = null;

    /**
     * @var Bee|null
     *
     * @ORM\ManyToOne(targetEntity="Bee", inversedBy="children")
     */
    protected $parent = null;

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
     * Get Children
     *
     * @return Bee[]|null
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set Children
     *
     * @param Bee[]|null $children
     *
     * @return $this
     */
    public function setChildren(array $children = null)
    {
        if (is_array($children)) {
            foreach ($children as $bee) {
                $this->addChild($bee);
            }
        } else {
            $this->children = null;
        }

        return $this;
    }

    /**
     * @param Bee $bee
     *
     * @return $this
     */
    public function addChild(Bee $bee)
    {
        if(!is_array($this->children)) {
            $this->children = new ArrayCollection();
        }

        $this->children->add($bee);
        $bee->setParent($this);

        return $this;
    }

    /**
     * Get Parent
     *
     * @return Bee|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set Parent
     *
     * @param Bee|null $parent
     *
     * @return $this
     */
    public function setParent(Bee $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Return rather or not this bee is the queen bee.
     *
     * @return bool
     */
    public function isQueen()
    {
        return (!($this->parent instanceof Bee));
    }

    /**
     * Apply damages to the current bee
     *
     * @return $this
     */
    public function hit()
    {
        $this->remainingLifespan -= $this->hitDamages;

        return $this;
    }

    /**
     * Return rather or not the current bee is dead.
     *
     * @return bool
     */
    public function isDead()
    {
        return ($this->remainingLifespan <= 0);
    }
}

