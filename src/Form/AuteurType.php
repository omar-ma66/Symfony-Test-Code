<?php

namespace App\Form;

use App\Entity\Auteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType ;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class ,[
                'label' => "Nom de l'Auteur ",
                'label_attr'=> ["style" => "font-weight: bold; color: #1b5e20; margin-bottom: 5px; display: block; "],
                'attr' => [
                    'style' => 'width: 100%; padding: 10px; border: 2px solid #2e7d32; border-radius: 8px;',
                    'placeholder'=>' Entrez le nom...'
                ]
            ])
            ->add('prenom',TextType::class ,[
                'label' => "Prenom de l'Auteur ",
                'label_attr'=> ["style" => " font-weight: bold; color: #1b5e20; margin-bottom: 5px; display: block;"],
                'attr' => [
                    'style' =>  'width: 100%; padding: 10px; border: 2px solid #2e7d32; border-radius: 8px;',
                    'placeholder' => 'Entrez le prenom..'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Auteur::class,
        ]);
    }
}
