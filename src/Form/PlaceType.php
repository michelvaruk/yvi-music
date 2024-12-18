<?php

namespace App\Form;

use App\Entity\Place;
use App\Form\CustomType\QuillTextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom du lieu'
            ])
            ->add('description', QuillTextareaType::class)
            ->add('address', TextType::class, [
                'label' => 'Adresse',
            ])
            ->add('zipCode', TextType::class, [
                'label' => 'Code postal',
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
            ])
            ->add('phone', TextType::class, [
                'label' => 'Numéro de téléphone',
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email de contact',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Place::class,
        ]);
    }
}
