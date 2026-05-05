<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use App\Repository\LieuRepository;
use App\Repository\TerrainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        LieuRepository $lieuRepo,
        TerrainRepository $terrainRepo,
        EvenementRepository $evenementRepo
    ): Response {
        return $this->render('home/index.html.twig', [
            'derniers_lieux'       => $lieuRepo->findBy(['estValide' => true], ['createdAt' => 'DESC'], 6),
            'derniers_terrains'    => $terrainRepo->findBy(['estDisponible' => true], ['createdAt' => 'DESC'], 3),
            'prochains_evenements' => $evenementRepo->findBy([], ['dateDebut' => 'ASC'], 3),
        ]);
    }

    #[Route('/carte', name: 'app_carte')]
    public function carte(
        LieuRepository $lieuRepo,
        TerrainRepository $terrainRepo,
        EvenementRepository $evenementRepo
    ): Response {
        $lieux     = $lieuRepo->findBy(['estValide' => true]);
        $terrains  = $terrainRepo->findBy(['estDisponible' => true]);
        $evenements = $evenementRepo->findByFiltres();

        return $this->render('home/carte.html.twig', [
            'lieux'      => $lieux,
            'terrains'   => $terrains,
            'evenements' => $evenements,
        ]);
    }
}