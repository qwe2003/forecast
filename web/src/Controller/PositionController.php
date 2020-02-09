<?php

namespace App\Controller;

use App\Entity\Position;
use App\Form\PositionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PositionController extends AbstractController
{
    /**
     * @Route("/position", name="position")
     */
    public function index()
    {
        $positions = $this->getDoctrine()
        ->getRepository(Position::class)
        ->findAll();

        if (!$positions) {
            throw $this->createNotFoundException(
                'No employees found'
            );
        }

        return $this->render('position/index.html.twig', [
            'positions' => $positions,
        ]);
    }

    /**
     * @Route("/position/save")
     */
    public function save(Request $request)
    {
        $position = new Position();

        $form = $this->createForm(PositionType::class, $position);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $position = $form->getData();

           
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($position);
            $entityManager->flush();

            return $this->redirectToRoute('position');
        }

        return $this->render('position/save.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/position/update/{positionId}", name="position_update")
     */
    public function update(int $positionId, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $position = $entityManager->getRepository(Position::class)->find($positionId);

        $form = $this->createForm(PositionType::class, $position);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $position = $form->getData();
            $entityManager->flush();

            return $this->redirectToRoute('position');
        }

        return $this->render('position/save.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
