<?php

namespace App\Controller\Enseignant;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Proposition;
use App\Form\PropositionType;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/enseignant/proposition')]
final class PropositionController extends AbstractController
{
    #[Route('/new', name: 'app_enseignant_proposition_new', methods: ['GET', 'POST'])]
    public function new(Request $resquest, EntityManagerInterface $entity): Response
    {
        $proposition = new Proposition();
        $form = $this->createForm(PropositionType::class, $proposition);
        $form->handleRequest($resquest);

        if ($form->isSubmitted() && $form->isValid()) {
            $entity->persist($proposition);
            $entity->flush();

            return $this->redirectToRoute('app_enseignant_proposition_new');
        }

        return $this->render('enseignant/proposition/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
