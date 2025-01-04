<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'required' => false
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom*'
            ])
            ->add('phone', TextType::class, [
                'label' => 'Votre n° de téléphone',
                'required' => false
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse mail*'
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Votre message*'
            ])
            ->add('check', CheckboxType::class , [
                'mapped' => false,
                'required' => false,
                'row_attr' => [
                    'class' => 'hidden'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}