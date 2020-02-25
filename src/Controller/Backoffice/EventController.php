<?php

namespace App\Controller\Backoffice;

use App\Entity\Event;
use App\Entity\User;
use App\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


class EventController extends AbstractController
{

    /**
     * @Route("/event", name="event")
     */
    public function index()
    {
        $user = $this->getUser();
        $username = $user -> getEmail();

        $allEvent = $this->getDoctrine()->getRepository(Event::class);
        $Events = $allEvent->findAll();

        return $this->render('/event/index.html.twig', [
            'Events' => $Events,
            'username' => $username,
        ]);
    }

    /**
     * @Route("/event/create", name="event_create")
     */

    public function create(Request $request)
    {
        $user = $this->getUser();
        $username = $user -> getEmail();
        $userid = $user -> getId();
        $event = new Event();

        $form = $this->createFormBuilder($event)

            ->add('name', TextType::class)
            ->add('isOn', HiddenType::class,[
                'data' => '0',
            ])
            ->add('user', HiddenType::class, [
                'data' => $user,
            ])
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $event = $form->getData();

            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($event);
            $entitymanager->flush();

            return $this->redirectToRoute('event');
        }
        return $this->render('event/create.html.twig', [
            'form' => $form->createView(),
            'username' => $username,
            'userid' => $userid,
        ]);
    }

    /**
     * @Route("/event/edit/{id}", name="event_edit")
     */
    public function edit(int $id, Request $request)
    {
        $user = $this->getUser();
        $username = $user -> getEmail();
        $Event = $this->getDoctrine()->getRepository(Event::class)->find($id);



        $form = $this->createFormBuilder($Event)
            ->add('name', TextType::class)
            ->add('isOn', TextType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $event = $form->getData();

            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($event);
            $entitymanager->flush();

            return $this->redirectToRoute('event');
        }

        return $this->render('/event/edit.html.twig', [
            'form' => $form->createView(),
            'Event' => $Event,
            'username' => $username,
        ]);
    }



}

