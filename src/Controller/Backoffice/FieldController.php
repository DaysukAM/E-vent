<?php

namespace App\Controller\Backoffice;


use App\Entity\Event;
use App\Entity\Field;
use App\Form\FieldType;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FieldController extends AbstractController
{
    /**
     * @Route("/event/field/{id}", name="field")
     */
    public function index(int $id)
    {
        $allEventFields = $this->getDoctrine()->getRepository(Field::class);
        $EventFields = $allEventFields->findBy(['event' => $id]);

        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);

        return $this->render('field/index.html.twig', [
            'controller_name' => 'FieldController',
            'EventFields' => $EventFields,
            'event'=>$event
        ]);
    }

    /**
     * @Route("/event/field/add/{id}", name="field_create")
     */
    public function create(int $id, Request $request)
    {

        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);

        $field = new Field();
        $form = $this->createFormBuilder($field)
            ->add('name')
            ->add('type', EntityType::Class, [
                'class' => \App\Entity\FieldType::class,
                'choice_label' => 'name'


            ])
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $field = $form->getData();
            $field->setEvent($event);

            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($field);
            $entitymanager->flush();

            return $this->redirectToRoute('field',[
                'id'=> $id
            ]);
        }
        return $this->render('field/create.html.twig', [
            'controller_name' => 'FieldController',
            'form' => $form->createView(),
        ]);
    }
}
