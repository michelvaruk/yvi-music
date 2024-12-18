<?php

namespace App\Form;

use App\Entity\Member;
use App\Entity\Project;
use App\Form\CustomType\ImageFileType;
use App\Form\CustomType\QuillTextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('bio', QuillTextareaType::class, [
                'field_name' => 'bio',
                'label' => 'Biographie',
            ])
            ->add('instruments', TextType::class, [
                'label' => 'Instruments'
            ])
            ->add('pictureFile', ImageFileType::class, [
                'field_name' => 'pictureFile',
                'label' => 'Photo de profil'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
