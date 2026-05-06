<?php

namespace App\Controller;

use App\Repository\AvisRepository;
use App\Repository\EvenementRepository;
use App\Repository\LieuRepository;
use App\Repository\TerrainRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin', name: 'app_admin_')]
#[IsGranted('ROLE_ADMIN')]
final class AdminController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(
        LieuRepository $lieuRepo,
        TerrainRepository $terrainRepo,
        EvenementRepository $evenementRepo,
        UserRepository $userRepo,
        AvisRepository $avisRepo
    ): Response
    {
        return $this->render('admin/index.html.twig', [
            'stats' => [
                'lieux'    => $lieuRepo->count([]),
                'lieuxEnAttente' => $lieuRepo->count(['estValide' => false]),
                'terrains' => $terrainRepo->count([]),
                'evenements' => $evenementRepo->count([]),
                'users'    => $userRepo->count([]),
                'avis'     => $avisRepo->count([]),
            ],
            'derniers_lieux'  => $lieuRepo->findBy(['estValide' => false], ['createdAt' => 'DESC'], 10),
            'derniers_users'  => $userRepo->findBy([], ['id' => 'DESC'], 5),
            'derniers_avis'   => $avisRepo->findBy([], ['createdAt' => 'DESC'], 5),
        ]);
    }

    #[Route('/lieux', name: 'lieux')]
    public function lieux(LieuRepository $lieuRepo): Response
    {
        return $this->render('admin/lieux.html.twig', [
            'lieux' => $lieuRepo->findBy([], ['createdAt' => 'DESC']),
        ]);
    }

    #[Route('/lieu/{id}/valider', name: 'lieu_valider')]
    public function validerLieu(
        int $id,
        LieuRepository $lieuRepo,
        EntityManagerInterface $em
    ): Response {
        $lieu = $lieuRepo->find($id);
        if ($lieu) {
            $lieu->setEstValide(!$lieu->isEstValide());
            $em->flush();
            $this->addFlash('success', $lieu->isEstValide() ? '✅ Lieu validé !' : '⚠️ Lieu dépublié.');
        }
        return $this->redirectToRoute('app_admin_lieux');
    }

    #[Route('/lieu/{id}/supprimer', name: 'lieu_supprimer')]
    public function supprimerLieu(
        int $id,
        LieuRepository $lieuRepo,
        EntityManagerInterface $em
    ): Response {
        $lieu = $lieuRepo->find($id);
        if ($lieu) {
            $em->remove($lieu);
            $em->flush();
            $this->addFlash('success', '🗑️ Lieu supprimé.');
        }
        return $this->redirectToRoute('app_admin_lieux');
    }

    #[Route('/users', name: 'users')]
    public function users(UserRepository $userRepo): Response
    {
        return $this->render('admin/users.html.twig', [
            'users' => $userRepo->findBy([], ['id' => 'DESC']),
        ]);
    }
}
