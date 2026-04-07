<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Repository\CategorieRepository;
use App\Repository\LieuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/lieux', name: 'app_lieu_')]
class LieuController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(
        request $request,
        LieuRepository $lieuRepo,
        CategorieRepository $categorieRepo
    ): Response {
        $categorieSlug = $request->query->get('categorie');
        $recherche     = $request->query->get('q');

        $categories = $categorieRepo->findAll();

        $lieux = $lieuRepo->findByFiltres($categorieSlug, $recherche);
        
        return $this->render('lieu/index.html.twig', [
            'lieux'          => $lieux,
            'categories'     => $categories,
            'categorieSlug'  => $categorieSlug,
            'recherche'      => $recherche,
        ]);
    }

    #[Route('/{slug}', name: 'show')]
    public function show(Lieu $lieu, EntityManagerInterface $em): Response
    {
        // Incrémenter le nombre de vues
        $lieu->setNombreVues($lieu->getNombreVues() + 1);
        $em->flush();

        return $this->render('lieu/show.html.twig', [
            'lieu' => $lieu,
        ]);
    }
}
