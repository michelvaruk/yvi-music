<?php

namespace App\Form;

use App\Entity\Site;
use App\Form\CustomType\ImageFileType;
use App\Form\CustomType\QuillTextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre du site'
            ])
            ->add('logoFile', ImageFileType::class, [
                'label' => 'Logo',
                'field_name' => 'logoFile'
            ])
            ->add('pictureFile', ImageFileType::class, [
                'label' => 'Image principale du site',
                'field_name' => 'pictureFile'
            ])
            ->add('phone', TextType::class, [
                'label' => 'N° de téléphone'
            ])
            ->add('description', QuillTextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Site::class,
        ]);
    }
}
