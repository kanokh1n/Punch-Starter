<?php

namespace App\Controller;

use App\Entity\Likes;
use App\Repository\ProjectsRepository;
use App\Repository\LikesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Psr\Log\LoggerInterface;

class LikesController extends AbstractController
{
    private $entityManager;
    private $projectRepository;
    private $likesRepository;
    private $logger;

    public function __construct(EntityManagerInterface $entityManager, ProjectsRepository $projectRepository, LikesRepository $likesRepository, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->projectRepository = $projectRepository;
        $this->likesRepository = $likesRepository;
        $this->logger = $logger;
    }

    #[Route('/project/{projectId}/like', name: 'like_project', methods: ['POST'])]
    public function like(int $projectId): JsonResponse
    {
        $this->logger->info("Like request received for project ID: $projectId");

        $project = $this->projectRepository->find($projectId);
        $user = $this->getUser();

        if (!$project) {
            $this->logger->error("Project not found: $projectId");
            return new JsonResponse(['error' => 'Project not found'], 404);
        }

        if (!$user) {
            $this->logger->error("User not logged in");
            throw new AccessDeniedException('You need to be logged in to like a project.');
        }

        $existingLike = $this->likesRepository->findOneBy(['user' => $user, 'project' => $project]);

        if ($existingLike) {
            $this->logger->error("Project already liked by user");
            return new JsonResponse(['error' => 'You already liked this project'], 400);
        }

        $like = new Likes();
        $like->setUser($user);
        $like->setProject($project);

        $this->entityManager->persist($like);
        $this->entityManager->flush();

        // Получаем актуальное количество лайков
        $likesCount = $this->likesRepository->count(['project' => $project]);

        return new JsonResponse(['message' => 'Project liked successfully', 'likesCount' => $likesCount], 200);
    }

    #[Route('/project/{projectId}/unlike', name: 'unlike_project', methods: ['DELETE'])]
    public function unlike(int $projectId): JsonResponse
    {
        $this->logger->info("Unlike request received for project ID: $projectId");

        $project = $this->projectRepository->find($projectId);
        $user = $this->getUser();

        if (!$project) {
            $this->logger->error("Project not found: $projectId");
            return new JsonResponse(['error' => 'Project not found'], 404);
        }

        if (!$user) {
            $this->logger->error("User not logged in");
            throw new AccessDeniedException('You need to be logged in to unlike a project.');
        }

        $like = $this->likesRepository->findOneBy(['user' => $user, 'project' => $project]);

        if (!$like) {
            $this->logger->error("Project not liked by user");
            return new JsonResponse(['error' => 'You have not liked this project'], 400);
        }

        $this->entityManager->remove($like);
        $this->entityManager->flush();

        // Получаем актуальное количество лайков
        $likesCount = $this->likesRepository->count(['project' => $project]);

        return new JsonResponse(['message' => 'Project unliked successfully', 'likesCount' => $likesCount], 200);
    }
}







