<?php

namespace App\Controller;

use App\Entity\Pledges;
use App\Entity\Projects;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PledgesController extends AbstractController
{
    #[Route('/make_donation/{projectId}', name: 'make_donation', methods: ['POST'])]
    public function makeDonation(
        int $projectId,
        Request $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    ): Response {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $amount = $request->request->get('amount');
        $project = $entityManager->getRepository(Projects::class)->find($projectId);

        if (!$project) {
            throw $this->createNotFoundException('Project not found');
        }

        $pledge = new Pledges();
        $pledge->setUserId($user);  // Передача объекта пользователя
        $pledge->setProjectId($project);
        $pledge->setAmount($amount);
        $pledge->setCreatedAt(new \DateTimeImmutable());

        $entityManager->persist($pledge);

        // Обновляем текущую сумму проекта
        $projectInfo = $project->getProjectInfo();
        $projectInfo->setCurrentAmount($projectInfo->getCurrentAmount() + $amount);

        $entityManager->flush();

        return $this->redirectToRoute('view_project', ['id' => $projectId]);
    }
}


