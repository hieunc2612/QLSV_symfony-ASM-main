<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Form\TeacherType;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Exception;



/**
 * @Route("/teacher")
 */
class TeacherController extends AbstractController
{
    /**
     * @Route("/", name="app_teacher_index", methods={"GET"})
     * @param TeacherRepository $TeacherRepository
     * @param Request $request
     
     *
     * @return Response
     */
    public function index(request $request, TeacherRepository $teacherRepository): Response
    {
        $Name = $request->query->get('Name');

        $expressionBuilder = Criteria::expr();
        $criteria = new Criteria();

        if (!is_null($Name) && !empty(($Name))) {
            $criteria->andWhere($expressionBuilder->contains('Name', $Name));
        }
        $filteredList = $teacherRepository->matching($criteria);

            return $this->renderForm('teacher/index.html.twig', [
                'teachers' => $filteredList
            ]);
        
    }

    /**
     * @Route("/new", name="app_teacher_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TeacherRepository $teacherRepository): Response
    {
        $teacher = new Teacher();
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teacherRepository->add($teacher, true);

            return $this->redirectToRoute('app_teacher_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('teacher/new.html.twig', [
            'teacher' => $teacher,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_teacher_show", methods={"GET"})
     */
    public function show(Teacher $teacher): Response
    {
        return $this->render('teacher/show.html.twig', [
            'teacher' => $teacher,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_teacher_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Teacher $teacher, TeacherRepository $teacherRepository): Response
    {
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teacherRepository->add($teacher, true);

            return $this->redirectToRoute('app_teacher_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('teacher/edit.html.twig', [
            'teacher' => $teacher,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_teacher_delete", methods={"POST"})
     */
    public function delete(Request $request, Teacher $teacher, TeacherRepository $teacherRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$teacher->getId(), $request->request->get('_token'))) {
            $teacherRepository->remove($teacher, true);
        }

        return $this->redirectToRoute('app_teacher_index', [], Response::HTTP_SEE_OTHER);
    }
}
