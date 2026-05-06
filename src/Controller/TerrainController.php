<?php

namespace App\Controller;

use App\Entity\Terrain;
use App\Form\TerrainType;
use App\Repository\TerrainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/terrains', name: 'app_terrain_')]
class TerrainController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(
        Request $request,
        TerrainRepository $terrainRepo
    ): Response {
        $recherche     = $request->query->get('q');
        $filtreDouche  = $request->query->get('douche');
        $filtreElec    = $request->query->get('electricite');
        $filtreWifi    = $request->query->get('wifi');
        $filtreGratuit = $request->query->get('gratuit');

        $terrains = $terrainRepo->findByFiltres(
            $recherche, $filtreDouche, $filtreElec, $filtreWifi, $filtreGratuit
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

    #[Route('/nouveau', name: 'new')]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $terrain = new Terrain();
        $form    = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $terrain->setCreatedAt(new \DateTimeImmutable());
            $terrain->setEstDisponible(true);
            $terrain->setUser($this->getUser());

            $em->persist($terrain);
            $em->flush();

            $this->addFlash('success', '✅ Votre terrain a été publié !');
            return $this->redirectToRoute('app_terrain_index');
        }

        return $this->render('terrain/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(Terrain $terrain): Response
    {
        return $this->render('terrain/show.html.twig', [
            'terrain' => $terrain,
        ]);
    }
}