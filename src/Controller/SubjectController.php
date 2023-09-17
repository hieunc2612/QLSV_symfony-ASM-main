<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Form\SubjectType;
use App\Repository\SubjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @Route("/subject")
 */
class SubjectController extends AbstractController
{
   /**
     * @Route("/", name="app_subject_index", methods={"GET"})
     * @param SubjectRepository $subjectRepository
     * @param Request $request
     
     *
     * @return Response
     */
    public function index(request $request,SubjectRepository $subjectRepository): Response
    {
        $Name = $request->query->get('Name');

        $expressionBuilder = Criteria::expr();
        $criteria = new Criteria();

        if (!is_null($Name) && !empty(($Name))) {
            $criteria->andWhere($expressionBuilder->contains('Name', $Name));
        }
        $filteredList = $subjectRepository->matching($criteria);

            return $this->renderForm('subject/index.html.twig', [
                'subjects' => $filteredList
            ]);
    }

    /**
     * @Route("/new", name="app_subject_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SubjectRepository $subjectRepository): Response
    {
        $subject = new Subject();
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subjectRepository->add($subject, true);

            return $this->redirectToRoute('app_subject_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('subject/new.html.twig', [
            'subject' => $subject,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_subject_show", methods={"GET"})
     */
    public function show(Subject $subject): Response
    {
        return $this->render('subject/show.html.twig', [
            'subject' => $subject,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_subject_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Subject $subject, SubjectRepository $subjectRepository): Response
    {
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subjectRepository->add($subject, true);

            return $this->redirectToRoute('app_subject_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('subject/edit.html.twig', [
            'subject' => $subject,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_subject_delete", methods={"POST"})
     */
    public function delete(Request $request, Subject $subject, SubjectRepository $subjectRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subject->getId(), $request->request->get('_token'))) {
            $subjectRepository->remove($subject, true);
        }

        return $this->redirectToRoute('app_subject_index', [], Response::HTTP_SEE_OTHER);
    }
}
