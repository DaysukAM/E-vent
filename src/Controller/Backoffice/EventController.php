<?php

namespace App\Controller\Backoffice;

use App\Entity\Event;
use App\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $allEvent = $this->getDoctrine()->getRepository(Event::class);
        $Events = $allEvent->findAll();

        return $this->render('/event/index.html.twig', [
            'Events' => $Events,
        ]);
    }

    /**
     * @Route("/event/create", name="event_create")
     */

    public function create(Request $request)
    {
        $event = new Event();

        $form = $this->createFormBuilder($event)
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
        return $this->render('event/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/event/edit/{id}", name="event_edit")
     */
    public function edit(int $id, Request $request)
    {
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
        ]);
    }



}

