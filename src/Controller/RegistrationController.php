<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class RegistrationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/registration', name: 'app_registration')]
    public function register(Request $request): Response
    {
        // Создание нового экземпляра сущности пользователя
        $user = new Users();

        // Создание формы регистрации, связанной с сущностью пользователя
        $form = $this->createForm(UsersFormType::class, $user);

        // Обработка отправки формы
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Проверка на существование пользователя с таким же email
            $existingUser = $this->entityManager->getRepository(Users::class)->findOneBy(['email' => $user->getEmail()]);
            if ($existingUser instanceof Users) {
                // Если пользователь с таким email уже существует, выведите сообщение об ошибке
                $this->addFlash('error', 'Пользователь с таким email уже зарегистрирован.');
                return $this->redirectToRoute('app_registration');
            }

            // Хеширование пароля перед сохранением в базу данных
            $passwordHash = password_hash($user->getPasswordHash(), PASSWORD_DEFAULT);
            $user->setPasswordHash($passwordHash);

            // Установка времени создания
            $user->setCreatedAt(new \DateTimeImmutable());

            // Сохранение пользователя в базе данных
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // Редирект на страницу с сообщением об успешной регистрации
            return $this->redirectToRoute('registration_success');
        }

        // Отображение шаблона с формой регистрации
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/registration/success', name: 'registration_success')]
    public function registrationSuccess(): Response
    {
        // Отображение страницы с сообщением об успешной регистрации
        return $this->render('registration/success.html.twig');
    }

}
