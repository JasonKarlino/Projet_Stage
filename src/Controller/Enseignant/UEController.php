<?php

namespace App\Controller\Enseignant;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\UE;
use App\Form\UEType;
use App\Repository\UERepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/enseignant/ue')]
final class UEController extends AbstractController
{
    #[Route('/new', name: 'app_enseignant_ue_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ue = new UE();
        $form = $this->createForm(UEType::class, $ue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ue);
            $entityManager->flush();

            return $this->redirectToRoute('app_enseignant_ue_new');
        }

        return $this->render('enseignant/ue/new.html.twig', [
            'form' => $form->createView(),
            
        ]);
    }

    #[Route('/list', name: 'app_enseignant_ue_list', methods: ['GET'])]
    public function list(UERepository $uerepository): Response
    {
        $ues = $uerepository->findAll();
        return $this->render('enseignant/ue/list.html.twig', [
            'ues' => $ues,
        ]);
    }

    #[Route('/show/{id}', name: 'app_enseignant_ue_show', methods: ['GET'])]
    public function show(?UE $ue): Response
    {
        return $this->render('enseignant/ue/show.html.twig', [
            'ue' => $ue,
        ]);
    }

    #[Route('/show/chapitres/{id}', name: 'app_enseignant_ue_show_chapitres', methods: ['GET'])]
    public function showChapitres(?UE $ue): Response
    {
        return $this->render('enseignant/ue/showChapitres.html.twig', [
            'ue' => $ue,
        ]);
    }
}
