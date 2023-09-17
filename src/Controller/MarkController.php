<?php

namespace App\Controller;

use App\Entity\Mark;
use App\Form\MarkType;
use App\Repository\MarkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
/**
 * @Route("/mark")
 */
class MarkController extends AbstractController
{
    /**
     * @Route("/", name="app_mark_index", methods={"GET"})
     * @param MarkRepository $markRepository
     * @param Request $request
     
     *
     * @return Response
     */
    public function index(request $request,MarkRepository $markRepository): Response
    {
        
        $Name = $request->query->get('Name');

        $expressionBuilder = Criteria::expr();
        $criteria = new Criteria();

        if (!is_null($Name) && !empty(($Name))) {
            $criteria->andWhere($expressionBuilder->contains('Status', $Name));
        }
        $filteredList = $markRepository->matching($criteria);

            return $this->renderForm('mark/index.html.twig', [
                'marks' => $filteredList
            ]);
    }

    /**
     * @Route("/new", name="app_mark_new", methods={"GET", "POST"})
     */
    public function new(Request $request, MarkRepository $markRepository): Response
    {
        $mark = new Mark();
        $form = $this->createForm(MarkType::class, $mark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $markRepository->add($mark, true);

            return $this->redirectToRoute('app_mark_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mark/new.html.twig', [
            'mark' => $mark,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_mark_show", methods={"GET"})
     */
    public function show(Mark $mark): Response
    {
        return $this->render('mark/show.html.twig', [
            'mark' => $mark,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_mark_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Mark $mark, MarkRepository $markRepository): Response
    {
        $form = $this->createForm(MarkType::class, $mark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $markRepository->add($mark, true);

            return $this->redirectToRoute('app_mark_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mark/edit.html.twig', [
            'mark' => $mark,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_mark_delete", methods={"POST"})
     */
    public function delete(Request $request, Mark $mark, MarkRepository $markRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mark->getId(), $request->request->get('_token'))) {
            $markRepository->remove($mark, true);
        }

        return $this->redirectToRoute('app_mark_index', [], Response::HTTP_SEE_OTHER);
    }
}
