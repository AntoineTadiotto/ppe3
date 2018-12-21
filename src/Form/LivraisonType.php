<?php

namespace App\Form;


use App\Entity\LivraisonOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', TextType::class, ['label' => 'Nom*'])
        ->add('prenom', TextType::class, ['label' => 'Prénom*'])
        ->add('adresse1', TextType::class, ['label' => 'Adresse*'])
        ->add('adresse2', null , ['label' => 'Adresse complémentaire'])
        ->add('codepostal', TextType::class, ['label' => 'Code postal*'])
        ->add('ville', TextType::class, ['label' => 'Ville*'])
        ->add('telephone', TextType::class, ['label' => 'Numéro de téléphone*'])
        ->add('enregistrer', SubmitType::class, ['label' => 'enregistrer'])
       
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LivraisonOrder::class,
        ]);
    }
}
