<?php

namespace App\Form;

use App\Entity\UE;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UEType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'Code UE'
                ])
            ->add('intitule', TextType::class, [
                'label' => 'Intitulé UE'
                ])
            ->add('nbreCredits', NumberType::class, [
                'label' => 'Nombre de crédits'
                ])
            ->add('semestre', NumberType::class, [
                'label' => 'Semestre'
                ])
            ->add('annee', NumberType::class, [
                'label' => 'Année'
                ])
            ->add('Ajouter', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary mt-3']
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UE::class,
        ]);
    }
}
