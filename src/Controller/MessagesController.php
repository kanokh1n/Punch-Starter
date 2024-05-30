<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Repository\ProjectsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Psr\Log\LoggerInterface;

class MessagesController extends AbstractController
{
    #[Route('/send-message/{projectId}', name: 'send_message', methods: ['POST'])]
    public function sendMessage(Request $request, EntityManagerInterface $entityManager, ProjectsRepository $projectRepository, Security $security, int $projectId, LoggerInterface $logger): Response
    {
        $user = $security->getUser();
        if (!$user) {
            $logger->error('Current user not found.');
            throw $this->createNotFoundException('Current user not found.');
        }

        $logger->info('Current user ID: ' . $user->getId());

        // Получение пользователя через проект
        $recipient = $projectRepository->findUserByProjectId($projectId);
        if (!$recipient) {
            $logger->error("Recipient for project ID {$projectId} not found.");
            throw $this->createNotFoundException('Recipient not found.');
        }

        $message = new Messages();
        $message->setTitle($request->request->get('title'));
        $message->setContent($request->request->get('content'));
        $message->setSenderId($user);
        $message->setAbsorberId($recipient);

        $entityManager->persist($message);
        $entityManager->flush();

        return $this->redirectToRoute('view_project', ['id' => $projectId]);
    }
}





