<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class EmployeeController extends AbstractController
{
    /**
     * @Route("/employee", name="employee")
     */
    public function list()
    {
        $employees = $this->getDoctrine()
        ->getRepository(Employee::class)
        ->findAll();

        if (!$employees) {
            return $this->redirectToRoute('employee_save');
        }

        return $this->render('employee/list.html.twig', [
            'employees' => $employees,
        ]);
    }

    /**
     * @Route("/employee/save", name="employee_save")
     */
    public function save(Request $request)
    {
        $employee = new Employee();

        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $employee = $form->getData();

           
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($employee);
            $entityManager->flush();

            return $this->redirectToRoute('employee');
        }

        return $this->render('employee/save.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}