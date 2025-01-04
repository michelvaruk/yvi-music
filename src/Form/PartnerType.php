<?php

namespace App\Form;

use App\Entity\Partner;
use App\Form\CustomType\ImageFileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('pictureName', ImageFileType::class, [
                'label' => 'Logo du partenaire',
                'field_name' => 'pictureFile'
            ])
            ->add('url', UrlType::class, [
                'label' => 'Lien externe',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partner::class,
        ]);
    }
}
