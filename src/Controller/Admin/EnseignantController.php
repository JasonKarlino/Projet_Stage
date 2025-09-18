<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Enseignant;
use App\Form\EnseignantType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/enseignant')]
final class EnseignantController extends AbstractController
{
    #[Route('/new', name: 'app_admin_enseignant_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $enseignant = new Enseignant();
        $form = $this->createForm(EnseignantType::class, $enseignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $enseignant = $form->getData();
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('app_admin_enseignant_new');
        }

        return $this->render('admin/enseignant/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
