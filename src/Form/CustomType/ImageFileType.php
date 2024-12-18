<?php

namespace App\Form\CustomType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\File;

class ImageFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add($options['field_name'], VichImageType::class, [
                'label' => $options['label_name'],
                'required' => false,
                'allow_delete' => false,
                'constraints' => new File([
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                        'image/gif',
                        'image/webp',
                        'image/svg+xml',
                        'image/tiff',
                        'image/bmp',
                    ],
                    'mimeTypesMessage' => 'Merci de télécharger un fichier image ou photo valide.',
                ])
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'inherit_data' => true,
            'field_name' => 'imageFile',
            'label_name' => false,
        ]);
    }
}