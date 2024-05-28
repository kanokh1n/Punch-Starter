<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Likes;
use App\Entity\Projects;
use App\Entity\ProjectInfo;
use App\Entity\User;
use App\Form\ProjectsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProjectsController extends AbstractController
{
    #[Route('/projects/create', name: 'create_project', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return new Response('You must be logged in to create a project', Response::HTTP_UNAUTHORIZED);
        }

        $project = new Projects();
        $form = $this->createForm(ProjectsFormType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $project->setUserId($user);
            $project->setStatus('Active');
            $projectInfo = $project->getProjectInfo();
            $projectInfo->setCreatedAt(new \DateTimeImmutable());
            $projectInfo->setUpdatedAt(new \DateTimeImmutable());

            $imageFile = $form['projectInfo']['project_img']->getData();
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                $imageDirectory = rtrim($this->getParameter('image_directory'), '/') . '/';

                try {
                    $imageFile->move(
                        $imageDirectory,
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Обработка ошибки, если не удалось переместить файл
                }

                $projectInfo->setProjectImg($newFilename);
            }


            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('app_projects');
        }

        return $this->render('projects/createProject.html.twig', [
            'form' => $form->createView(),
            'is_edit' => false,
            'project_image_url' => '',
        ]);
    }

    #[Route('/projects', name: 'app_projects')]
    public function index(Security $security, UrlGeneratorInterface $urlGenerator): Response
    {
        $user = $security->getUser();

        if ($user === null) {
            return $this->redirectToRoute('app_main');
        }

        $projects = $user->getProjects();

        return $this->render('projects/projects.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/projects/view/{id}', name: 'view_project')]
    public function view(int $id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $project = $entityManager->getRepository(Projects::class)->find($id);

        if (!$project) {
            throw $this->createNotFoundException('Проект не найден');
        }

        if ($request->isMethod('POST')) {
            $commentContent = $request->request->get('content');

            $comment = new Comments();
            $comment->setContent($commentContent);
            $comment->setUserId($this->getUser());
            $comment->setProjectsId($project);
            $comment->setCreatedAt(new \DateTimeImmutable());

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('view_project', ['id' => $id]);
        }

        return $this->render('projects/viewProject.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/projects/{id}/delete', name: 'delete_project', methods: ['POST'])]
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        $project = $entityManager->getRepository(Projects::class)->find($id);

        if (!$project) {
            throw $this->createNotFoundException('Проект не найден');
        }

        // Удаляем все связанные записи Likes
        $likes = $entityManager->getRepository(Likes::class)->findBy(['project' => $project]);
        foreach ($likes as $like) {
            $entityManager->remove($like);
        }

        $entityManager->remove($project);
        $entityManager->flush();

        return $this->redirectToRoute('app_projects');
    }


    #[Route('/projects/edit/{id}', name: 'edit_project', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = $entityManager->getRepository(Projects::class)->find($id);

        if (!$project) {
            throw $this->createNotFoundException('Проект не найден');
        }

        $form = $this->createForm(ProjectsFormType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $project->getProjectInfo()->setUpdatedAt(new \DateTimeImmutable());

            $imageFile = $form['projectInfo']['project_img']->getData();
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
                $imageDirectory = rtrim($this->getParameter('image_directory'), '/') . '/';

                try {
                    $imageFile->move(
                        $this->getParameter('kernel.project_dir') . '/public/' . $imageDirectory,
                        $newFilename
                    );
                    $project->getProjectInfo()->setProjectImg($newFilename);
                } catch (FileException $e) {
                    // Обработка ошибки
                }
            }

            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('app_projects');
        }

        $projectImageUrl = $project->getProjectInfo()->getProjectImg()
            ? '/' . rtrim($this->getParameter('image_directory'), '/') . '/' . $project->getProjectInfo()->getProjectImg()
            : '';

        return $this->render('projects/createProject.html.twig', [
            'form' => $form->createView(),
            'is_edit' => true,
            'project_image_url' => $projectImageUrl,
        ]);
    }

}
