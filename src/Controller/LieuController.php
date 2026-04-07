<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\LieuType;
use App\Repository\CategorieRepository;
use App\Repository\LieuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/lieux', name: 'app_lieu_')]
class LieuController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(
        Request $request,
        LieuRepository $lieuRepo,
        CategorieRepository $categorieRepo
    ): Response {
        $categorieSlug = $request->query->get('categorie');
        $recherche     = $request->query->get('q');
        $categories    = $categorieRepo->findAll();
        $lieux         = $lieuRepo->findByFiltres($categorieSlug, $recherche);

        return $this->render('lieu/index.html.twig', [
            'lieux'         => $lieux,
            'categories'    => $categories,
            'categorieSlug' => $categorieSlug,
            'recherche'     => $recherche,
        ]);
    }

    #[Route('/nouveau', name: 'new')]
    #[IsGranted('ROLE_USER')]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        SluggerInterface $slugger
    ): Response {
        $lieu = new Lieu();
        $form = $this->createForm(LieuType::class, $lieu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lieu->setSlug(strtolower($slugger->slug($lieu->getTitre())));
            $lieu->setCreatedAt(new \DateTimeImmutable());
            $lieu->setEstValide(true); // validation par admin
            $lieu->setNombreVues(0);
            $lieu->setUser($this->getUser());

            $em->persist($lieu);
            $em->flush();

            $this->addFlash('success', '✅ Votre lieu a été soumis et sera validé prochainement !');
            return $this->redirectToRoute('app_lieu_index');
        }

        return $this->render('lieu/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'show')]
    public function show(Lieu $lieu, EntityManagerInterface $em): Response
    {
        $lieu->setNombreVues($lieu->getNombreVues() + 1);
        $em->flush();

        return $this->render('lieu/show.html.twig', [
            'lieu' => $lieu,
        ]);
    }
}