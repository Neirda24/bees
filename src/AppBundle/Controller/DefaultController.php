<?php

namespace AppBundle\Controller;

use AppBundle\Manager\BeeManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $gameManager = $this->get('app.manager.game');
        /** @var BeeManager $beeManager */
        $beeManager = $this->get('app.manager.bee');
        $gameManager->initBeeManager();

        return $this->render('AppBundle:Default:index.html.twig', [
            'bees_alive'    => $beeManager->getRemainingBees(),
            'game_finished' => $gameManager->isGameFinished(),
        ]);
    }

    /**
     * @Route("/hit", name="hit")
     */
    public function hitAction(Request $request)
    {
        $gameManager = $this->get('app.manager.game');
        $gameManager->initBeeManager();
        $beeManager = $this->get('app.manager.bee');
        $beeManager->hitRandom();
        $currentGame = $gameManager->getCurrentGame();
        $currentGame->addNumberRound();
        $em = $this->getDoctrine()->getManager();
        $em->persist($currentGame);
        $em->flush($currentGame);

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/new", name="new")
     */
    public function newAction(Request $request)
    {
        $gameManager        = $this->get('app.manager.game');
        $queenBee           = $gameManager->getCurrentGame(true)->getQueenBee();
        $queenBeeRepository = $this->get('app.repository.queen_bee');
        $queenBeeRepository->refillBees($queenBee);
        $otherBeeRepository = $this->get('app.repository.other_bee');
        $otherBeeRepository->refillBees($queenBee);

        return $this->redirectToRoute('homepage');
    }
}
