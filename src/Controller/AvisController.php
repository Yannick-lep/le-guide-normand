<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Lieu;
use App\Entity\Terrain;
use App\Form\AvisType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/avis', name: 'app_avis_')]
class AvisController extends AbstractController
{
    #[Route('/lieu/{id}', name: 'lieu_new', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function newAvisLieu(
        Lieu $lieu,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avis->setUser($this->getUser());
            $avis->setLieu($lieu);
            $avis->setCreatedAt(new \DateTimeImmutable());
            $avis->setEstValide(true);

            $em->persist($avis);
            $em->flush();

            $this->addFlash('success', '✅ Votre avis a été publié !');
        }

        return $this->redirectToRoute('app_lieu_show', ['slug' => $lieu->getSlug()]);
    }

    #[Route('/terrain/{id}', name: 'terrain_new', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function newAvisTerrain(
        Terrain $terrain,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avis->setUser($this->getUser());
            $avis->setTerrain($terrain);
            $avis->setCreatedAt(new \DateTimeImmutable());
            $avis->setEstValide(true);

            $em->persist($avis);
            $em->flush();

            $this->addFlash('success', '✅ Votre avis a été publié !');
        }

        return $this->redirectToRoute('app_terrain_show', ['id' => $terrain->getId()]);
    }
}