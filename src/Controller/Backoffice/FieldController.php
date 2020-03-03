<?php

namespace App\Controller\Backoffice;


use App\Entity\Field;
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
        return $this->render('field/index.html.twig', [
            'controller_name' => 'FieldController',
            'EventFields' => $EventFields
        ]);
    }
    /**
     * @Route("/event/field/add/{id}", name="field")
     */
    public function create(int $id, Request $request)
    {
        $field = new Field;
        $allEventFields = $this->getDoctrine()->getRepository(Field::class);
        $EventFields = $allEventFields->findBy(['event' => $id]);
        return $this->render('field/index.html.twig', [
            'controller_name' => 'FieldController',
            'EventFields' => $EventFields
        ]);
    }
}
