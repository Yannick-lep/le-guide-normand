<?php

namespace App\Controller;

use App\Entity\Terrain;
use App\Repository\TerrainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/terrains', name: 'app_terrain_')]
class TerrainController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(
        Request $request,
        TerrainRepository $terrainRepo
    ): Response {
        $recherche = $request->query->get('q');
        $filtreDouche = $request->query->get('douche');
        $filtreElec   = $request->query->get('electricite');
        $filtreWifi   = $request->query->get('wifi');
        $filtreGratuit = $request->query->get('gratuit');

        $terrains = $terrainRepo->findByFiltres(
            $recherche,
            $filtreDouche,
            $filtreElec,
            $filtreWifi,
            $filtreGratuit
        );

        return $this->render('terrain/index.html.twig', [
            'terrains'      => $terrains,
            'recherche'     => $recherche,
            'filtreDouche'  => $filtreDouche,
            'filtreElec'    => $filtreElec,
            'filtreWifi'    => $filtreWifi,
            'filtreGratuit' => $filtreGratuit,
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(Terrain $terrain, EntityManagerInterface $em): Response
    {
        return $this->render('terrain/show.html.twig', [
            'terrain' => $terrain,
        ]);
    }
}

