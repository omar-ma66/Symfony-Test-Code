<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image',FileType::class ,[
             'label' => "Choisir une image ...",
             'required' =>false,
             'mapped'  => false,
             'constraints'=>[
                new File(
                    maxSize : "5M",
                    mimeTypes: [
                        'image/png',
                        'image/jpg',
                        'image/jpeg',
                        'image/webp',
                    ],
                    mimeTypesMessage:"vous n'avez pas choisi le bon format ..."

                )
             ]   
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
