<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Bee;
use AppBundle\Entity\Game;
use AppBundle\Entity\QueenBee;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Exception;
use Symfony\Component\HttpFoundation\Session\Session;

class GameManager
{
    /**
     * The default queen bee name (used only for test and because lack of time)
     *
     * @var string
     */
    const DEFAULT_QUEEN_BEE_NAME = 'Queen Bee';

    /**
     * @var string
     */
    const SESSION_CURRENT_GAME = 'current_game_id';

    /**
     * @var Game|null
     */
    protected $currentGame;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManagerInterface;

    /**
     * @var EntityRepository
     */
    protected $gameRepository;

    /**
     * @var EntityRepository
     */
    protected $queenBeeRepository;

    /**
     * @var BeeManager
     */
    protected $beeManager;

    /**
     * @var Session
     */
    protected $session;

    /**
     * Constructor.
     *
     * @param EntityRepository       $gameRepository
     * @param EntityRepository       $queenBeeRepository
     * @param EntityManagerInterface $entityManagerInterface
     * @param BeeManager             $beeManager
     * @param Session                $session
     */
    public function __construct(
        EntityRepository $gameRepository,
        EntityRepository $queenBeeRepository,
        EntityManagerInterface $entityManagerInterface,
        BeeManager $beeManager,
        Session $session
    ) {
        $this->gameRepository         = $gameRepository;
        $this->entityManagerInterface = $entityManagerInterface;
        $this->beeManager             = $beeManager;
        $this->session = $session;
        $this->queenBeeRepository = $queenBeeRepository;
    }

    /**
     * Return rather or not the game is finished.
     *
     * @return bool
     */
    public function isGameFinished()
    {
        return ($this->beeManager->getRemainingBees()->count() <= 0);
    }

    /**
     * @param QueenBee $queenBee
     *
     * @return Bee[]
     */
    protected function extractAliveBeesFromQueenBee(QueenBee $queenBee)
    {
        $result = [];
        if (!$queenBee->isDead()) {
            $result[] = $queenBee;
            $otherBees = $queenBee->getOtherBees();

            foreach($otherBees as $otherBee) {
                if (!$otherBee->isDead()) {
                    $result[] = $otherBee;
                }
            }
        }

        return $result;
    }

    /**
     * @return $this
     *
     * @throws Exception
     */
    public function initBeeManager()
    {
        $currentGame = $this->getCurrentGame();
        $bees = $this->extractAliveBeesFromQueenBee($currentGame->getQueenBee());
        $this->beeManager->setAliveBeeCollection($bees);

        return $this;
    }

    /**
     * @param bool $forceNew
     *
     * @return Game
     * @throws Exception
     */
    public function getCurrentGame($forceNew = false)
    {
        if (true === $forceNew) {
            $this->currentGame = null;
        }

        if (!($this->currentGame instanceof Game)) {
            if (false === $forceNew && $this->session->has(static::SESSION_CURRENT_GAME)) {
                $this->currentGame = $this->gameRepository->find($this->session->get(static::SESSION_CURRENT_GAME));
            } else {
                $queenBee = $this->queenBeeRepository->findOneBy([
                    'name' => static::DEFAULT_QUEEN_BEE_NAME,
                ]);

                if (!($queenBee instanceof QueenBee)) {
                    throw new Exception('? did you change the database ?');
                }

                $newGame = new Game();
                $newGame->setQueenBee($queenBee);

                $this->entityManagerInterface->persist($newGame);
                $this->entityManagerInterface->flush($newGame);

                $this->session->set(static::SESSION_CURRENT_GAME, $newGame->getId());

                $this->currentGame = $newGame;
            }
        }

        return $this->currentGame;
    }
}
