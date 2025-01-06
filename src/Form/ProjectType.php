<?php

namespace App\Form;

use App\Entity\Member;
use App\Entity\Project;
use App\Entity\YoutubeLink;
use App\Form\CustomType\ImageFileType;
use App\Form\CustomType\QuillTextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom du projet'
            ])
            ->add('style', TextType::class, [
                'label' => 'Styles du projet',
                'attr' => [
                    'placeholder' => 'Jazz, fanfare'
                ]
            ])
            ->add('presentation', QuillTextareaType::class, [
                'label' => 'Présentation du projet',
                'field_name' => 'presentation',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email du projet',
                'required' => false
            ])
            ->add('youtube', UrlType::class, [
                'label' => 'Lien vers la page de la chaîne Youtube du projet',
                'required' => false,
            ])
            ->add('facebook', UrlType::class, [
                'label' => 'Lien vers la page Facebook du projet',
                'required' => false,
            ])
            ->add('instagram', UrlType::class, [
                'label' => 'Lien vers la page Instagram du projet',
                'required' => false,
            ])
            ->add('pictureFile', ImageFileType::class, [
                'label' => 'Image de présentation du projet',
                'field_name' => 'pictureFile'
            ])
            ->add('pdfFile', ImageFileType::class, [
                'label' => 'Documentation technique',
                'field_name' => 'pdfFile'
            ])
            ->add('members', EntityType::class, [
                'label' => 'Musiciens',
                'class' => Member::class,
                'choice_label' => function(Member $member) {
                    return ucfirst($member->getFirstname()) . ' ' . ucfirst($member->getLastname());
                },
                'multiple' => true,
                'expanded' => true
            ])
            ->add('youtubeLinks', CollectionType::class, [
                'label' => 'Liens Youtube',
                'entry_type' => YoutubeLinkType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_options' => ['label' => false],
                'attr' => [
                    'data-controller' => 'form-collection'
                ]
            ])
            ->add('galleries', CollectionType::class, [
                'label' => 'Photos du projet',
                'entry_type' => GalleryType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_options' => [
                    'label' => false],
                'attr' => [
                    'data-controller' => 'form-collection'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
