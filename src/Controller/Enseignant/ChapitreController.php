<?php

namespace App\Controller\Enseignant;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Chapitre;
use App\Form\ChapitreType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/enseignant/chapitre')]
final class ChapitreController extends AbstractController
{
    #[Route('/new', name: 'app_enseignant_chapitre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    { 
        $chapitre = new Chapitre();
        $form = $this->createForm(ChapitreType::class, $chapitre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($chapitre);
            $entityManager->flush();

            return $this->redirectToRoute('app_enseignant_chapitre_new');
        }

        return $this->render('enseignant/chapitre/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/show/{id}', name: 'app_enseignant_chapitre_show', methods: ['GET'])]
    public function show(?Chapitre $chapitre): Response
    {
        return $this->render('enseignant/chapitre/show.html.twig', [
            'chapitre' => $chapitre,
        ]);
    }
}
