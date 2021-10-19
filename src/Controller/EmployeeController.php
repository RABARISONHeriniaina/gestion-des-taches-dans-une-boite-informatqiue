<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Repository\EmployeeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/employee")
 */
class EmployeeController extends AbstractController
{
    /**
     * @Route("/", name="employee_index", methods={"GET"})
     */
    public function index(EmployeeRepository $employeeRepository, Request $request, PaginatorInterface $paginatorInterface): Response
    {

        $employees = $paginatorInterface->paginate(
            $employeeRepository->findAll(),
            $request->query->get("page", 1),
            5
        );


        return $this->render('employee/index.html.twig', [
            'employees' => $employees,
        ]);
    }

    /**
     * @Route("/new", name="employee_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($employee);
            $entityManager->flush();

            return $this->redirectToRoute('employee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee/new.html.twig', [
            'employee' => $employee,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="employee_show", methods={"GET"})
     */
    public function show(Employee $employee, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $tasks = $paginatorInterface->paginate(
            $employee->getTask(),
            $request->query->get("page", 1),
            10
        );

        return $this->render('employee/show.html.twig', compact('employee', 'tasks'));
    }

    /**
     * @Route("/{id}/edit", name="employee_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Employee $employee): Response
    {
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('employee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee/edit.html.twig', [
            'employee' => $employee,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="employee_delete", methods={"POST"})
     */
    public function delete(Request $request, Employee $employee): Response
    {
        if ($this->isCsrfTokenValid('delete' . $employee->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($employee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('employee_index', [], Response::HTTP_SEE_OTHER);
    }
}
