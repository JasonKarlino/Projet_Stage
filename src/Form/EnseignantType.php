<?php

namespace App\Form;

use App\Entity\Enseignant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EnseignantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom'
                ])
            ->add('prenoms', TextType::class, [
                'label' => 'Prénoms'
                ])
            ->add('matricule', TextType::class, [
                'label' => 'Matricule'
                ])
            ->add('grade', ChoiceType::class, [
                'choices'  => [
                    'Licence' => 'Licence',
                    'Master' => 'Master',
                    'Doctorat' => 'Doctorat',
                    'Autre' => 'Autre',
                ],
                'label' => 'Grade'
            ])
            ->add('mail', TextType::class, [
                'label' => 'Adresse Mail',
                'required' => false,
                ])
            ->add('contact', TextType::class, [
                'label' => 'Contact'
                ])
            ->add('ajouter', SubmitType::class, [
                'label' => 'Ajouter'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Enseignant::class,
        ]);
    }
}
