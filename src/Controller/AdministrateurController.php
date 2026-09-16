<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Administrateur;
use App\Form\AdminType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class AdministrateurController extends AbstractController
{
    #[Route('/admin/login', name: 'app_administrateur_login')]
    public function index(AuthenticationUtils $authentication): Response
    {
        $error = $authentication->getLastAuthenticationError();
        $lastUsername = $authentication->getLastUsername();

        return $this->render('administrateur/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route('/admin/admin', name: 'app_administrateur_admin_new', methods: ['GET', 'POST'])]
    public function admin(Request $request, EntityManagerInterface $entityManager , UserPasswordHasherInterface $passwordHasher): Response
    {
        $administrateur = new Administrateur();
        $form = $this->createForm(AdminType::class, $administrateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $administrateur = $form->getData();

            $plainPassword = $administrateur->getMotDePasse();
            $mail = $administrateur->getMail();

            $administrateur->setMail($mail);

            $hashedPassword = $passwordHasher->hashPassword($administrateur, $plainPassword);
            $administrateur->setMotDePasse($hashedPassword);

            $administrateur->setRoles(['ROLE_ADMIN']);

            $entityManager->persist($administrateur);
            $entityManager->flush();

            return $this->redirectToRoute('app_welcome');
        }

       
        return $this->render('admin/admin.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
