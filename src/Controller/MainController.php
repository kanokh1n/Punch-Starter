<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Projects;
use App\Entity\ProjectsCategories;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;

class MainController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, CategoriesRepository $categoriesRepository)
    {
        $this->entityManager = $entityManager;
        $this->categoriesRepository = $categoriesRepository;
    }

    #[Route('/main/{page?}', name: 'app_main')]
    public function main(PaginatorInterface $paginator, Request $request, $page = 1): Response
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('p')
            ->from(Projects::class, 'p')
            ->join('p.projectInfo', 'pi') // Присоединяем связанную таблицу ProjectInfo
            ->orderBy('pi.likes', 'DESC'); // Сортируем по полю "likes" из связанной таблицы

        $projectsQuery = $qb->getQuery();

        $page = $request->query->getInt('page', 1);

        $pagination = $paginator->paginate(
            $projectsQuery,
            $request->query->getInt('page', $page), // Текущая страница
            10 // Количество элементов на странице
        );

        return $this->render('main/index.html.twig', [
            'pagination' => $pagination,
            'categories' => $this->categoriesRepository->findAll()
        ]);
    }


    #[Route('/main/{categoryId?}', name: 'app_main_category')]
    public function findProjectByCategory(EntityManagerInterface $entityManager, $categoryId = null): Response
    {
        // Получаем репозиторий сущности Categories
        $categoriesRepository = $entityManager->getRepository(Categories::class);

        // Находим категорию по её ID
        $category = $categoriesRepository->find($categoryId);

        // Проверяем, существует ли категория с заданным ID
        if (!$category) {
            throw $this->createNotFoundException('Категория не найдена');
        }

        // Получаем все проекты, связанные с выбранной категорией
        $projects = $category->getProjectsCategories()->map(function ($projectCategory) {
            return $projectCategory->getProjectId();
        });

        // Преобразуем коллекцию проектов в массив
        $projects = $projects->toArray();

        return $this->render('main/index.html.twig', [
            'projects' => $projects,
            'categories' => $this->categoriesRepository->findAll(), // Добавляем список категорий
        ]);
    }

}
