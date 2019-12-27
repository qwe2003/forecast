<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\Employee;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployeeController extends AbstractController
{
    /**
     * @Route("/employee/list")
     */
    public function list()
    {
        $employees = $this->getDoctrine()
        ->getRepository(Employee::class)
        ->findAll();

        if (!$employees) {
            throw $this->createNotFoundException(
                'No employees found'
            );
        }

        return $this->render('employee/list.html.twig', [
            'employees' => $employees,
        ]);
    }
}