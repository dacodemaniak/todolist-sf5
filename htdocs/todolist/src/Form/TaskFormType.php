<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TaskFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                null,
                [
                    "label" => false
                ]
            )
            ->add(
                'summary',
                null,
                [
                    "label" => false
                ]
            )
            ->add(
                'isEnabled',
                null,
                [
                    "label" => false
                ]
            )
            ->add(
                'priority',
                null,
                [
                    "label" => false
                ]
            )
            ->add(
                'category',
                EntityType::class,
                [
                    'class' => Category::class,
                    'choice_label' => 'title'
                ]
                
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
