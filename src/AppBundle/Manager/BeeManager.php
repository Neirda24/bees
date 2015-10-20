<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Bee;
use AppBundle\Entity\QueenBee;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class BeeManager
{
    /**
     * @var ArrayCollection
     */
    protected $aliveBeeCollection;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManagerInterface;

    /**
     * Constructor.
     *
     * @param EntityManagerInterface $entityManagerInterface
     */
    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->aliveBeeCollection     = new ArrayCollection();
        $this->entityManagerInterface = $entityManagerInterface;
    }

    /**
     * Set AliveBeeCollection
     *
     * @param array $aliveBeeCollection
     *
     * @return $this
     */
    public function setAliveBeeCollection(array $aliveBeeCollection = [])
    {
        $this->aliveBeeCollection = new ArrayCollection($aliveBeeCollection);

        return $this;
    }

    /**
     * Pick and hit a random bee among the one still alive.
     *
     * @return $this
     */
    public function hitRandom()
    {
        $bees = $this->aliveBeeCollection->toArray();
        /** @var Bee $bee */
        $bee = $bees[array_rand($bees, 1)];

        $bee->hit();
        $this->entityManagerInterface->persist($bee);
        $this->entityManagerInterface->flush($bee);

        if ($bee->isDead()) {
            if ($bee instanceof QueenBee) {
                $this->aliveBeeCollection = new ArrayCollection();
            } else {
                $this->aliveBeeCollection->removeElement($bee);
            }
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getRemainingBees()
    {
        return $this->aliveBeeCollection;
    }
}
