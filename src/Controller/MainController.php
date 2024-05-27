<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Projects;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Security;

class MainController extends AbstractController
{
    private $entityManager;
    private $categoriesRepository;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, CategoriesRepository $categoriesRepository, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->categoriesRepository = $categoriesRepository;
        $this->security = $security;
    }

    #[Route('/main/{page<\d+>?1}', name: 'app_main')]
    public function main(PaginatorInterface $paginator, Request $request, int $page = 1): Response
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('p', 'COUNT(l.id) AS HIDDEN likesCount')
            ->from(Projects::class, 'p')
            ->leftJoin('p.likes', 'l')
            ->groupBy('p.id')
            ->orderBy('likesCount', 'DESC');

        $projectsQuery = $qb->getQuery();

        $pagination = $paginator->paginate(
            $projectsQuery,
            $page, // Текущая страница
            10 // Количество элементов на странице
        );

        $user = $this->security->getUser();
        $projects = $pagination->getItems();

        // Определение, поставил ли пользователь лайк каждому проекту
        foreach ($projects as $project) {
            $project->isLikedByUser = $project->getLikes()->exists(function($key, $like) use ($user) {
                return $like->getUser() === $user;
            });
        }

        return $this->render('main/index.html.twig', [
            'pagination' => $pagination,
            'categories' => $this->categoriesRepository->findAll(),
            'user' => $user
        ]);
    }

    #[Route('/main/category/{categoryId}', name: 'app_main_category')]
    public function findProjectByCategory(Request $request, PaginatorInterface $paginator, int $categoryId): Response
    {
        $category = $this->categoriesRepository->find($categoryId);

        if (!$category) {
            throw $this->createNotFoundException('Категория не найдена');
        }

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('p', 'COUNT(l.id) AS HIDDEN likesCount')
            ->from(Projects::class, 'p')
            ->leftJoin('p.projectsCategories', 'pc')
            ->leftJoin('p.likes', 'l')
            ->where('pc.category = :category')
            ->setParameter('category', $category)
            ->groupBy('p.id')
            ->orderBy('likesCount', 'DESC');

        $projectsQuery = $qb->getQuery();

        $pagination = $paginator->paginate(
            $projectsQuery,
            $request->query->getInt('page', 1), // Текущая страница
            10 // Количество элементов на странице
        );

        $user = $this->security->getUser();
        $projects = $pagination->getItems();

        // Определение, поставил ли пользователь лайк каждому проекту
        foreach ($projects as $project) {
            $project->isLikedByUser = $project->getLikes()->exists(function($key, $like) use ($user) {
                return $like->getUser() === $user;
            });
        }

        return $this->render('main/index.html.twig', [
            'pagination' => $pagination,
            'categories' => $this->categoriesRepository->findAll(),
            'user' => $user
        ]);
    }
}



