<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Enseignant;
use App\Form\EnseignantType;
use App\Repository\EnseignantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/enseignant')]
final class EnseignantController extends AbstractController
{
    #[Route('/new', name: 'app_admin_enseignant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager , UserPasswordHasherInterface $passwordHasher): Response
    {
        $enseignant = new Enseignant();
        $form = $this->createForm(EnseignantType::class, $enseignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $enseignant = $form->getData();

            $plainPassword = $enseignant->getMotDePasse();
            $mail = $enseignant->getMail();

            $enseignant->setMail($mail);

            $hashedPassword = $passwordHasher->hashPassword($enseignant, $plainPassword);
            $enseignant->setMotDePasse($hashedPassword);

            $enseignant->setRoles(['ROLE_ENSEIGNANT']);

            $entityManager->persist($enseignant);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_enseignant_new');
        }

        return $this->render('admin/enseignant/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/list', name: 'app_admin_enseignant_list', methods: ['GET'])]
    public function list(EnseignantRepository $enseignantRepository): Response
    {
        $enseignants = $enseignantRepository->findAll();

        return $this->render('admin/enseignant/list.html.twig', [
            'enseignants' => $enseignants,
        ]);
    }

    #[Route('/show/{id}', name: 'app_admin_enseignant_show', methods: ['GET'])]
    public function show(?Enseignant $enseignant): Response
    {
        return $this->render('admin/enseignant/show.html.twig', [
            'enseignant' => $enseignant,
        ]);
    }

    #[Route('/show/ues/{id}', name: 'app_admin_enseignant_show_ues', methods: ['GET'])]
    public function showUes(?Enseignant $enseignant): Response
    {
        return $this->render('admin/enseignant/show_ues.html.twig', [
            'enseignant' => $enseignant,
        ]);
    }
}
