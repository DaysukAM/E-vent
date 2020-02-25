<?php

namespace App\Controller\Backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserSpaceController extends AbstractController
{
    /**
     * @Route("/userspace", name="user_space")
     */
    public function index()
    {

        $user = $this->getUser();
        $username = $user -> getEmail();

        return $this->render('user_space/index.html.twig', [
            'controller_name' => 'UserSpaceController',
            'user' => $username,
        ]);
    }
}
