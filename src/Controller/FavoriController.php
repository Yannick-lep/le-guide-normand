<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Repository\LieuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/favoris', name: 'app_favori_')]
#[IsGranted('ROLE_USER')]
class FavoriController extends AbstractController
{
    #[Route('/toggle/{id}', name: 'toggle', methods: ['POST'])]
    public function toggle(
        Lieu $lieu,
        EntityManagerInterface $em
    ): JsonResponse {
        $user = $this->getUser();

        if ($user->getFavoriLieux()->contains($lieu)) {
            $user->removeFavoriLieu($lieu);
            $estFavori = false;
        } else {
            $user->addFavoriLieu($lieu);
            $estFavori = true;
        }

        $em->flush();

        return $this->json([
            'estFavori' => $estFavori,
            'total'     => $user->getFavoriLieux()->count(),
        ]);
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('favori/index.html.twig', [
            'lieux' => $this->getUser()->getFavoriLieux(),
        ]);
    }
}
