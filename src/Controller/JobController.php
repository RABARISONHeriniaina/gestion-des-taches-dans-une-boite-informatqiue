<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\JobType;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/job")
 */
class JobController extends AbstractController
{
    /**
     * @Route("/", name="job_index", methods={"GET"})
     */
    public function index(JobRepository $jobRepository, Request $request): Response
    {
        $job = new Job();
        $form = $this->createForm(JobType::class, $job, [
            'action' => $this->generateUrl('job_new'),
            'method' => 'POST'
        ]);
        return $this->render('job/index.html.twig', [
            'jobs' => $jobRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/", name="job_new", methods={"GET", "POST"})
     */
    public function new(JobRepository $jobRepository, Request $request): Response
    {
        $job = new Job();
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($job);
            $entityManager->flush();
            $this->addFlash("success", "Ajout avec success");
            return $this->redirectToRoute('job_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('job/index.html.twig', [
            'jobs' => $jobRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="job_show", methods={"GET"})
     */
    public function show(Job $job): Response
    {
        return $this->render('job/show.html.twig', [
            'job' => $job,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="job_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, JobRepository $jobRepository, EntityManagerInterface $em): Response
    {
        $data = $request->request->all();
        $job = $jobRepository->findOneById($data["id"]);
        $job->setName($data["name"]);
        if ($this->isCsrfTokenValid('edit' . $job->getId(), $request->request->get('_token_edit'))) {
            $this->addFlash("success", "Modification avec success");
            $em->flush();
            goto finish;
        }
        $this->addFlash("error", "Erreur de modification, Reessaiez SVP!");
        finish:
        return $this->redirectToRoute('job_index');
    }

    /**
     * @Route("/{id}", name="job_delete", methods={"POST"})
     */
    public function delete(Request $request, Job $job): Response
    {
        if ($this->isCsrfTokenValid('delete' . $job->getId(), $request->request->get('_token_delete'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($job);
            $entityManager->flush();
            $this->addFlash("success", "Suppression avec success");
        }

        return $this->redirectToRoute('job_index', [], Response::HTTP_SEE_OTHER);
    }
}
