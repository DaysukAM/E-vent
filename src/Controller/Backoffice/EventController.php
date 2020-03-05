<?php

namespace App\Controller\Backoffice;

use App\Entity\Event;
use App\Entity\User;
use App\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;

class EventController extends AbstractController
{

    /**
     * @Route("/event", name="event")
     */
    public function index()
    {
        $user = $this->getUser();

        $allUserEvent = $this->getDoctrine()->getRepository(Event::class);
        $UserEvents = $allUserEvent->findBy(['user' => $user]);

        return $this->render('/event/index.html.twig', [
            'UserEvents' => $UserEvents,
        ]);
    }

    /**
     * @Route("/event/create", name="event_create")
     */

    public function create(Request $request)
    {
        $user = $this->getUser();
        $userid = $user -> getId();
        $event = new Event();

        $form = $this->createFormBuilder($event)

            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('isOn', HiddenType::class,[
                'data' => '0',
            ])
            ->add('color', TextType::class)
            ->add('file',FileType::class, [
                'mapped' => false,
                'label' => 'file to upload'
        ])
            ->add('save', SubmitType::class, [
                'label' => "Créer !"
        ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $request->files ->get('form')['file'];

            $uploads_directory = $this ->getParameter('uploads_directory');

            $filename = md5(uniqid()) . '.' . $file->guessExtension();

            $file -> move(
                $uploads_directory,
                $filename
            );

            $event = $form->getData();
            $event->setUser($user);

            $event-> setImage($filename);
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($event);
            $entitymanager->flush();

            return $this->redirectToRoute('event');
        }
        return $this->render('event/create.html.twig', [
            'form' => $form->createView(),
            'userid' => $userid,
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
            ->add('description', TextType::class)
            ->add('isOn', HiddenType::class)
            ->add('color', TextType::class)
            ->add('file',FileType::class, [
                'mapped' => false,
                'label' => 'file to upload'
            ])
            ->add('save', SubmitType::class, [
                'label' => "Créer !"
            ])
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
    /**
     * @Route("/event/delet/{id}", name="event_delete")
     */
    public function delete($id)
    {

        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($event);
        $entityManager->flush();
        return $this->redirectToRoute('event');
    }



}

