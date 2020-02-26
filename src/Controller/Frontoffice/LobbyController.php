<?php

namespace App\Controller\Frontoffice;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LobbyController extends AbstractController
{
    /**
     * @Route("/", name="lobby")
     */

    public function index()
    {
        $allUserEvent = $this->getDoctrine()->getRepository(Event::class);
        $Events = $allUserEvent->findAll();

        return $this->render('lobby/index.html.twig', [
            'controller_name' => 'LobbyController',
            'Events' => $Events,
        ]);
    }
}
