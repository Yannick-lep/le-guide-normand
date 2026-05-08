<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use App\Repository\LieuRepository;
use App\Repository\TerrainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RechercheController extends AbstractController
{
    #[Route('/recherche', name: 'app_recherche')]
    public function index(
        Request $request,
        LieuRepository $lieuRepo,
        TerrainRepository $terrainRepo,
        EvenementRepository $evenementRepo
    ): Response
    {
        $q = $request->query->get('q', '');

        if (strlen($q) < 2) {
            return $this->render('recherche/index.html.twig', [
                'q'           => $q,
                'lieux'       => [],
                'terrains'    => [],
                'evenements'  => [],
                'total'       => 0,
            ]);
        }

        $lieux      = $lieuRepo->findByFiltres(null, $q);
        $terrains   = $terrainRepo->findByFiltres($q);
        $evenements = $evenementRepo->findByFiltres($q);

        return $this->render('recherche/index.html.twig', [
            'q'          => $q,
            'lieux'      => $lieux,
            'terrains'   => $terrains,
            'evenements' => $evenements,
            'total'      => count($lieux) + count($terrains) + count($evenements),
        ]);
       
    }
}
