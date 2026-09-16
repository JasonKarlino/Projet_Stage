<?php

namespace App\Controller\Admin;

use App\Entity\Enseignant;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use App\Enum\Grade;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EnseignantCrudController extends AbstractCrudController
{
    public function __construct(
        private ?UserPasswordHasherInterface $passwordHasher = null
    ) {}

    public static function getEntityFqcn(): string
    {
        return Enseignant::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nomPrenom', 'Nom et prénoms'),
            NumberField::new('matricule'),
            ChoiceField::new('grade')
                ->setChoices([
                    'Licence' => Grade::Licence,
                    'Master' => Grade::Master,
                    'Doctorat' => Grade::Doctorat,
                ]),
            EmailField::new('mail', 'Email'),
            NumberField::new('contact'),
            TextField::new('plainPassword', 'Mot de passe')
                ->setRequired($pageName === Crud::PAGE_NEW || $pageName === Crud::PAGE_EDIT)
                ->setFormTypeOption('attr', ['autocomplete' => 'new-password', 'type' => 'password']),
            ArrayField::new('roles')->onlyOnIndex(),
        ];
    }

     public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Enseignant && $entityInstance->getPlainPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $entityInstance,
                $entityInstance->getPlainPassword()
            );
            $entityInstance->setMotDePasse($hashedPassword);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Enseignant && $entityInstance->getPlainPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $entityInstance,
                $entityInstance->getPlainPassword()
            );
            $entityInstance->setMotDePasse($hashedPassword);
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

}
