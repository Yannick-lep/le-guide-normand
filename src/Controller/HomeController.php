<?php

namespace App\Controller;

use App\Repository\AvisRepository;
use App\Repository\EvenementRepository;
use App\Repository\LieuRepository;
use App\Repository\TerrainRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
   #[Route('/', name: 'app_home')]
public function index(
    LieuRepository $lieuRepo,
    TerrainRepository $terrainRepo,
    EvenementRepository $evenementRepo,
    UserRepository $userRepo,
    AvisRepository $avisRepo
): Response {
    //Dernières activités fusionnées
    $activites = [];

    foreach ($lieuRepo->findBy(['estValide' => true], ['createdAt' => 'DESc'], 3) as $lieu) {
        $activites[] = [
            'type'       => 'lieu',
            'icone'      => 'fa-map-location-dot',
            'couleur'    => 'var(--normand-red',
            'message'    => '<strong>' . $lieu->getUser()->getPrenom() . '</strong> a partagé un nouveau lieu',
            'titre'      => $lieu->getTitre(),
            'lien'       => '/lieux/' . $lieu->getSlug(),
            'date'       => $lieu->getCreatedAt(),
        ];
    }

    foreach ($terrainRepo->findBy(['estDisponible' => true], ['createdAt' => 'DESC'], 2) as $terrain) {
        $activites[] = [
            'type'        => 'terrain',
            'icone'       => 'fa-tent',
            'couleur'     => 'var(--normand-green)',
            'message'     => '<strong>' . $terrain->getUser()->getPrenom() . '</strong> a proposé un terrain',
            'titre'       => $terrain->getTitre(),
            'lien'        => '/terrain/' . $terrain->getId(),
            'date'        => $terrain->getCreatedAt(),
        ];
    }

    foreach ($avisRepo->findBy(['estValide' => true], ['id' => 'DESC'], 3) as $avis) {
        $activites[] = [
            'type'       => 'avis',
            'icone'      => 'fa-star',
            'couleur'    => 'var(--normand-gold)',
            'message'    => '<strong>' . $avis->getUser()->getPrenom() . '</strong> a laissé un avis',
            'titre'      => $avis->getLieu() ? $avis->getLieu()->getTitre() : ($avis->getTerrain() ? $avis->getTerrain()->getTitre() : ''),
            'lien'       => $avis->getLieu() ? '/lieux/' . $avis->getLieu()->getSlug() : '#',
            'date'       => $avis->getCreatedAt(),
            'note'       => $avis->getNote(),
        ];
    }

    // Trier par date décroissante
    usort($activites, fn($a, $b) => $b['date'] <=> $a['date']);
    $activites = array_slice($activites, 0, 6);

    return $this->render('home/index.html.twig', [
        'derniers_lieux'       => $lieuRepo->findBy(['estValide' => true], ['createdAt' => 'DESC'], 6),
        'derniers_terrains'    => $terrainRepo->findBy(['estDisponible' => true], ['createdAt' => 'DESC'], 3),
        'prochains_evenements' => $evenementRepo->findByFiltres(null, null),
        'stats' => [
            'lieux'      => $lieuRepo->count(['estValide' => true]),
            'terrains'   => $terrainRepo->count(['estDisponible' => true]),
            'evenements' => $evenementRepo->count([]),
            'membres'    => $userRepo->count([]),
        ],
        'activites' => $activites,
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