<?php

namespace App\Controller;

use App\Entity\Projects;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/main', name: 'app_main')]
    public function main(): Response
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('p')
            ->from(Projects::class, 'p')
            ->join('p.projectInfo', 'pi') // Присоединяем связанную таблицу ProjectInfo
            ->orderBy('pi.likes', 'DESC'); // Сортируем по полю "likes" из связанной таблицы

        $projects = $qb->getQuery()->getResult();

        return $this->render('main/index.html.twig', [
            'projects' => $projects,
        ]);
    }
}
