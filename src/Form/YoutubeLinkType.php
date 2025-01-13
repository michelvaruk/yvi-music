<?php

namespace App\Form;

use App\Entity\YoutubeLink;
use App\Form\CustomType\QuillTextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class YoutubeLinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('url', TextType::class, [
                'label' => 'Lien Youtube',
                'attr' => [
                    'placeholder' => 'https://www.youtube.com/watch?v=qDhMzVn1CfA'
                ]
            ])
            ->add('description', QuillTextareaType::class, [
                'label' => 'Description'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => YoutubeLink::class,
        ]);
    }
}
