<?php

namespace App\Form;

use App\Entity\Calendar;
use App\Entity\Place;
use App\Entity\Project;
use App\Form\CustomType\ImageFileType;
use App\Repository\PlaceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('date', null, [
                'widget' => 'single_text',
                'label' => 'Date et heure',
            ])
            ->add('type', TextType::class, [
                'label' => 'Type de concert',
            ])
            ->add('url', UrlType::class, [
                'label' => 'Url de l\'événement',
                'required' => false,
            ])
            ->add('pictureFile', ImageFileType::class, [
                'field_name' => 'pictureFile',
                'label' => 'Image de présentation'
                ])
            ->add('project', EntityType::class, [
                'class' => Project::class,
                'choice_label' => 'title',
                'label' => 'Projet',
            ])
            ->add('place', EntityType::class, [
                'class' => Place::class,
                'choice_label' => function(?Place $place) {
                    return $place->getTitle() . ' - ' . $place->getCity();
                },
                'label' => 'Lieu',
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
            'data_class' => Calendar::class,
        ]);
    }
}
