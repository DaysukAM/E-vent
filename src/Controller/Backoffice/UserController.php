<?php

namespace App\Controller\Backoffice;


use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    /**
     * @Route("/myinfo", name="myinfo")
     */
    public function index(Request $request)
    {

        $user = $this->getUser();


        $form = $this->createForm(RegisterType::class, $user)
            ->add('password',HiddenType::class)
            ->add('save', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();


            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($user);
            $entitymanager->flush();
        }

        return $this->render('user/info.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request)
    {

        $user = new User();

        $form = $this->createForm(RegisterType::class)
            ->add('save', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                $form->get("password")->getData()
            ));

            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($user);
            $entitymanager->flush();

            return $this->redirectToRoute('lobby');
        }



        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
