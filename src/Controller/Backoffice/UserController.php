<?php

namespace App\Controller\Backoffice;


use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {


        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
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
            var_dump($user);
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($user);
            $entitymanager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
    /**
     * @Route("/userspace", name="userspace")
     */
    public function userspace(Request $request)
    {


        return $this->render('user_space/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
