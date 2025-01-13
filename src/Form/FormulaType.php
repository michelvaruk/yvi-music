<?php

namespace App\Form;

use App\Entity\Formula;
use App\Form\CustomType\QuillTextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormulaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('format', TextType::class, [
                'label' => 'Format',
                'attr' => [
                    'placeholder' => '2 fois 40 minutes'
                ]
            ])
            ->add('type', TextType::class, [
                'label' => 'Type',
                'attr' => [
                    'placeholder' => 'Concert assis'
                ]
            ])
            ->add('description', QuillTextareaType::class, [
                'label' => 'Decscription',
            ])
            ->add('active', CheckboxType::class, [
                'label' => 'Activer',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formula::class,
        ]);
    }
}
