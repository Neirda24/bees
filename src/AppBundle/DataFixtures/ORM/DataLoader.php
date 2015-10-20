<?php

namespace AppBundle\DataFixtures\ORM;

use Hautelook\AliceBundle\Doctrine\DataFixtures\AbstractLoader;

class DataLoader extends AbstractLoader
{
    /**
     * {@inheritdoc}
     */
    public function getFixtures()
    {
        return [
            __DIR__ . '/drone_bees.yml',
            __DIR__ . '/worker_bees.yml',
            __DIR__ . '/queen_bees.yml',
        ];
    }
}
