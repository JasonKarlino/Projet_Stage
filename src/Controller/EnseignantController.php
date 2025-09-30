<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class EnseignantController extends AbstractController
{
    #[Route('/enseignant/login', name: 'app_enseignant_login')]
    public function index(AuthenticationUtils $authentication): Response
    {
        $error = $authentication->getLastAuthenticationError();
        $lastUsername = $authentication->getLastUsername();

        return $this->render('enseignant/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }
}
