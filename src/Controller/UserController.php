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
        ]);
    }

    #[Route('/profile/edit', name: 'app_profile_edit')]
    public function editProfile(Request $request): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createNotFoundException('User not found.');
        }

        // Создаем массив данных для формы на основе свойств объекта User
        $userData = [
            'email' => $user->getEmail(),
            'fio' => $user->getFio(),
            'phone' => $user->getPhone(),
            'description' => $user->getDescription(),
            // Добавьте остальные свойства, которые нужно передать в форму
        ];

        // Создаем форму редактирования профиля и передаем массив данных
        $editForm = $this->createForm(UserFormType::class, $userData);

        // Обрабатываем запрос на редактирование профиля
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // Если форма была отправлена и валидна, обновляем сущность User на основе данных из формы
            $formData = $editForm->getData();

            $user->setEmail($formData['email']);
            $user->setFio($formData['fio']);
            $user->setPhone($formData['phone']);
            $user->setDescription($formData['description']);
            // Обновите остальные свойства объекта User на основе данных из формы

            // Проверяем, был ли предоставлен новый пароль
            if (isset($formData['newPassword']) && $formData['newPassword']) {
                // Hash and set the new password only if it is provided
                $hashedPassword = $this->passwordHasher->hashPassword($user, $formData['newPassword']);
                $user->setPassword($hashedPassword);
            }

            // Сохраняем изменения в базе данных
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'Profile updated successfully.');

            // Перенаправляем пользователя на страницу профиля после сохранения изменений
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/edit.html.twig', [
            'user' => $user,
            'editForm' => $editForm->createView(),
        ]);
    }

}





