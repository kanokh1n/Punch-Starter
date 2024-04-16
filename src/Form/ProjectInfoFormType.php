<?php

namespace App\Form;

use App\Entity\ProjectInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectInfoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Название проекта',
            ])
            ->add('description', TextType::class, [
                'label' => 'Описание проекта',
            ])
            ->add('current_amount', NumberType::class, [
                'label' => 'Текущая сумма',
            ])
            ->add('goal_amount', NumberType::class, [
                'label' => 'Целевая сумма',
            ])
            ->add('project_img', TextType::class, [
                'label' => 'Изображение проекта',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProjectInfo::class,
        ]);
    }
}

