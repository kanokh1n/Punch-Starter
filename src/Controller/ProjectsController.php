<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectsController extends AbstractController
{
    #[Route('/projects', name: 'app_projects')]
    public function index(): Response
    {
        return $this->render('projects/index.html.twig', [
            'controller_name' => 'ProjectsController',
        ]);
    }

    /**
     * @Route("/project/{id}", name="project_details")
     */
    public function details($id): Response
    {
        // Вместо реальных данных о проекте здесь могут быть запросы к базе данных
        $project = [
            'id' => 1,
            'name' => 'Название проекта ' . 1,
            'description' => 'Описание проекта ' . 1,
        ];

        // Заглушка для метода details контроллера проектов
        return $this->render('project/details.html.twig', [
            'project' => $project,
        ]);
    }
}
