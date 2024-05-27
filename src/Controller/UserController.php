<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/profile', name: 'app_profile')]
    public function profile(Request $request): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createNotFoundException('User not found.');
        }

        return $this->render('profile/profile.html.twig', [
            'user' => $user,
            'is_edit' => false, // Viewing mode
        ]);
    }

    #[Route('/profile/edit', name: 'app_profile_edit')]
    public function editProfile(Request $request): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createNotFoundException('User not found.');
        }

        $userData = [
            'email' => $user->getEmail(),
            'fio' => $user->getFio(),
            'phone' => $user->getPhone(),
            'description' => $user->getDescription(),
        ];

        $editForm = $this->createForm(UserFormType::class, $userData);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $formData = $editForm->getData();

            $user->setEmail($formData['email']);
            $user->setFio($formData['fio']);
            $user->setPhone($formData['phone']);
            $user->setDescription($formData['description']);

            if (isset($formData['newPassword']) && $formData['newPassword']) {
                $hashedPassword = $this->passwordHasher->hashPassword($user, $formData['newPassword']);
                $user->setPassword($hashedPassword);
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'Profile updated successfully.');

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/profile.html.twig', [
            'user' => $user,
            'editForm' => $editForm->createView(),
            'is_edit' => true, // Editing mode
        ]);
    }
}





