<?php

namespace App\Form;

use App\Entity\Chapitre;
use App\Entity\UE;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChapitreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $ueConnecte = $options['ue_connecte'];
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre du chapitre'
            ])
            ->add('contenu', TextareaType::class, [
                'label' => 'Contenu du chapitre'
            ])
            ->add('ue', EntityType::class, [
                'class' => UE::class,
                'choice_label' => 'code',
                'data' => $ueConnecte, 
                'disabled' => true,            
                'label' => 'UE'
            ])
            ->add('Ajouter', SubmitType::class, [ 
                'attr' => ['class' => 'btn btn-primary mt-3']
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chapitre::class,
            'ue_connecte' => null,
        ]);
    }
}
