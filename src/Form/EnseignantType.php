<?php

namespace App\Form;

use App\Entity\Enseignant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver; 
use App\Enum\Grade;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EnseignantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomPrenom', TextType::class, [
                'label' => 'Nom et prénoms',
                'attr' => [
                    'placeholder' => 'Entrez le nom et les prénoms',
                ],
            ])
            ->add('matricule', Numbertype::class, [
                'label' => 'Matricule',
                'attr' => [
                    'placeholder' => 'Entrez le matricule',
                ],
            ])
            ->add('grade', EnumType::class, [
                'class' => Grade::class,
                'label' => 'Grade',
                'choice_label' => function(?Grade $grade) {
                    return $grade->getLabel();
                },
                'placeholder' => 'Sélectionnez le grade',
            ])
            ->add('mail', EmailType::class, [
                'label' => 'Adresse email',
                'attr' => [
                    'placeholder' => 'Entrez l\'adresse email',
                ],
            ])
            ->add('motDePasse', TextType::class, [
                'label' => 'Mot de passe',
                'attr' => [
                    'placeholder' => 'Entrez le mot de passe',
                ],
            ])

            ->add('contact', NumberType::class, [
                'label' => 'Contact',
                'attr' => [
                    'placeholder' => 'Entrez le contact',
                ],
            ])
            ->add('Ajouter', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary mt-3'],
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
