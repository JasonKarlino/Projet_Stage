<?php

namespace App\Form;

use App\Entity\Enseignant;
use App\Entity\Chapitre;
use App\Entity\Sujet;
use App\Entity\UE;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SujetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('duree', NumberType::class, [
                'label' => 'Durée',
                'attr' => ['min' => 1],
            ])
            ->add('nbreQuestion', NumberType::class, [
                'label' => 'Nombre de questions',
                'attr' => ['min' => 1],
            ])
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'attr' => ['maxlength' => 255],
            ])
            ->add('dateCreation', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('enseignant', EntityType::class, [
                'class' => Enseignant::class,
                'choice_label' => 'nomPrenom',
            ])

            ->add('ue', EntityType::class, [
                'class' => UE::class,
                'choice_label' => 'code',
            ])

            ->add('chapitres', EntityType::class, [
                'class' => Chapitre::class,
                'choice_label' => 'titre',
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'label' => 'Thèmes (chapitres) à privilégier',
            ])
            ->add('difficulte', ChoiceType::class, [
                'choices' => [
                    'Toutes' => null,
                    'Facile' => 'facile',
                    'Moyenne' => 'moyenne',
                    'Difficile' => 'difficile',
                ],
                'mapped' => false,
                'required' => false,
                'label' => 'Niveau de difficulté',
            ])
            ->add('typeQuestions', ChoiceType::class, [
                'choices' => [
                    'Tous' => null,
                    'QCM' => 'QCM',
                    'QCU' => 'QCU',
                    'Vrai ou Faux' => 'QB',
                ],
                'mapped' => false,
                'required' => false,
                'label' => 'Type de questions',
            ])


            ->add('envoyer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sujet::class,
        ]);
    }
}
