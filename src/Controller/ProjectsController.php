<?php

namespace App\Controller;

use App\Entity\Projects;
use App\Entity\ProjectInfo;
use App\Entity\User;
use App\Form\ProjectsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProjectsController extends AbstractController
{
    #[Route('/projects/create', name: 'create_project', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Получаем текущего аутентифицированного пользователя
        /** @var User $user */
        $user = $this->getUser();

        // Проверяем, аутентифицирован ли пользователь
        if (!$user) {
            // Возвращаем ошибку 401 Unauthorized, если пользователь не аутентифицирован
            return new Response('You must be logged in to create a project', Response::HTTP_UNAUTHORIZED);
        }

        // Получаем данные о проекте из запроса
        $requestData = $request->request->all();

        // Создаем новый проект
        $project = new Projects();

        // Устанавливаем пользователя владельца проекта
        $project->setUserId($user);

        // Создаем информацию о проекте
        $projectInfo = new ProjectInfo();
        $projectInfo->setTitle($requestData['title']);
        $projectInfo->setDescription($requestData['description']);
        $projectInfo->setCurrentAmount($requestData['current_amount']);
        $projectInfo->setGoalAmount($requestData['goal_amount']);
        $projectInfo->setProjectImg($requestData['project_img']);
        $projectInfo->setCreatedAt(new \DateTimeImmutable());
        $projectInfo->setUpdatedAt(new \DateTimeImmutable());
        $project->setStatus('Active');
        $projectInfo->setLikes(0);

        // Связываем проект с его информацией
        $project->setProjectInfo($projectInfo);

        // Сохраняем проект в базе данных
        $entityManager->persist($project);
        $entityManager->flush();

        // Получаем проекты текущего пользователя
        $projects = $user->getProjects();

        return $this->render('projects/projects.html.twig', [
            'projects' => $projects,
        ]);
    }


    #[Route('/projects/create', name: 'make_Project')]
    public function createProject(): Response
    {
        return $this->render('projects/createProject.html.twig', [
            'controller_name' => 'ProjectsController',
        ]);
    }

    #[Route('/projects', name: 'app_projects')]
    public function index(Security $security, UrlGeneratorInterface $urlGenerator): Response
    {
        // Получаем текущего залогиненного пользователя
        $user = $security->getUser();

        if ($user === null) {
            return $this->redirectToRoute('app_main');
        }

        // Получаем проекты текущего пользователя
        $projects = $user->getProjects();

        return $this->render('projects/projects.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/projects/view/{id}', name: 'view_project')]
    public function view(int $id, EntityManagerInterface $entityManager): Response
    {
        // Получаем проект для просмотра по его ID
        $project = $entityManager->getRepository(Projects::class)->find($id);

        // Проверяем, существует ли проект с указанным ID
        if (!$project) {
            throw $this->createNotFoundException('Проект не найден');
        }

        return $this->render('projects/viewProject.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/projects/{id}/delete', name: 'delete_project', methods: ['POST'])]
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        // Получаем проект для удаления по его ID
        $project = $entityManager->getRepository(Projects::class)->find($id);

        // Проверяем, существует ли проект с указанным ID
        if (!$project) {
            throw $this->createNotFoundException('Проект не найден');
        }

        // Удаляем проект из базы данных
        $entityManager->remove($project);
        $entityManager->flush();

        // Перенаправляем пользователя на страницу с проектами
        return $this->redirectToRoute('app_projects');
    }

    #[Route('/projects/edit/{id}', name: 'edit_project')]
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Получаем проект для редактирования по его ID
        $project = $entityManager->getRepository(Projects::class)->find($id);

        // Проверяем, существует ли проект с указанным ID
        if (!$project) {
            throw $this->createNotFoundException('Проект не найден');
        }

        // Создаем форму для редактирования проекта
        $form = $this->createForm(ProjectsFormType::class, $project);

        // Обрабатываем отправку формы
        $form->handleRequest($request);

        // Проверяем, была ли форма отправлена и прошла ли валидацию
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            // Сохраняем изменения в базе данных
            $entityManager->flush();

            // Перенаправляем пользователя на страницу с проектами или другую страницу по вашему выбору
            return $this->redirectToRoute('app_projects');
        }

        // Если форма не прошла валидацию, отображаем ее с ошибками
        return $this->render('projects/editProject.html.twig', [
            'form' => $form->createView(),
            'project' => $project,
        ]);
    }
}