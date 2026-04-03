<?php

namespace App\Controller;

use App\Repository\LieuRepository;
use App\Repository\TerrainRepository;
use App\Repository\EvenementRepository;
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
            'derniers_lieux'        => $lieuRepo->findBy(['estValide' => true], ['createdAt' => 'DESC'], 6),
            'derniers_terrains'     => $terrainRepo->findBy(['estDisponible' => true], ['createdAt' => 'DESC'], 3),
            'prochains_evenements'  => $evenementRepo->findBy([], ['dateDebut' => 'ASC'], 3),
        ]);
    }
}