<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/evenements', name: 'app_evenement_')]
class EvenementController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(
        Request $request,
        EvenementRepository $evenementRepo
    ): Response {
        $recherche    = $request->query->get('q');
        $filtreGratuit = $request->query->get('gratuit');

        $evenements = $evenementRepo->findByFiltres($recherche, $filtreGratuit);

        return $this->render('evenement/index.html.twig', [
            'evenements'    => $evenements,
            'recherche'     => $recherche,
            'filtreGratuit' => $filtreGratuit,
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }
}
