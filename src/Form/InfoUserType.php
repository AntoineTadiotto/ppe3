<?php

namespace App\Form;

use App\Entity\InfoUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class InfoUserType extends AbstractType
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
            ->add('submit', SubmitType::class, ['label'=>'enregistrer','attr'=>['class'=>'ui primary button']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InfoUser::class,
        ]);
    }
}
