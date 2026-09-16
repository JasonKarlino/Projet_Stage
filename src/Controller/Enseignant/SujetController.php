<?php

namespace App\Controller\Enseignant;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Sujet;
use App\Form\SujetType;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/enseignant/sujet')]
final class SujetController extends AbstractController
{
    #[Route('/new', name: 'app_enseignant_sujet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entity): Response
    {
        $sujet = new Sujet();
        $form = $this->createForm(SujetType::class, $sujet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entity->persist($sujet);
            $entity->flush();

            return $this->redirectToRoute('app_enseignant_sujet_new');
        }

        return $this->render('enseignant/sujet/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
