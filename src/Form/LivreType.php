<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Livre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\MoneyToLocalizedStringTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',TextType::class)
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'input' => 'datetime_immutable'
            ])
            ->add('prix',MoneyType::class)
            ->add('auteur',EntityType::class,[
                'class' => Auteur::class,
                'choice_label'=> function(Auteur $auteur){
                    return $auteur->getNom(). ' '.$auteur->getPrenom();
                },
                'placeholder'=>'Choisissez un auteur'
            ])
            ->add('categorie',ChoiceType::class,[
                'choices'=>[
                    "Roman"=>"roman",
                    "Science"=>"science",
                    "Science-fiction" =>"science-fiction",
                    "Fantastique" =>"fantastique",
                    "Policier" => "policier",
                    "Poetique" =>"poetique",
                    "Horreur" => "horreur"
                    ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
            'csrf_protection'=>true,
        ]);
    }
}
