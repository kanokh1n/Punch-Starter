<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Email',
                'disabled' => true, // Prevents editing the email
            ])
            ->add('fio', TextType::class, [
                'label' => 'ФИО',
            ])
            ->add('phone', TextType::class, [
                'label' => 'Телефон',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Описание',
            ])
            ->add('profile_img', FileType::class, [
                'label' => 'Профильное изображение',
                'required' => false, // Allow empty profile image field
            ])
            ->add('newPassword', PasswordType::class, [
                'label' => 'New Password',
                'mapped' => false,
                'required' => false, // Allow empty password field
                'constraints' => [
                    new Length(['min' => 6]),
                ],
            ])
            ->add('confirmPassword', PasswordType::class, [
                'label' => 'Confirm New Password',
                'mapped' => false,
                'required' => false, // Allow empty password field
                'constraints' => [
                    new Length(['min' => 6]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null, // No data class bound to this form
        ]);
    }
}

