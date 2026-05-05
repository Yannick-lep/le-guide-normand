<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/profil', name: 'app_profil_')]
#[IsGranted('ROLE_USER')]
class ProfilController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/modifier', name: 'edit')]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', '✅ Profil mis à jour avec succès !');
            return $this->redirectToRoute('app_profil_index');
        }

        return $this->render('profil/edit.html.twig', [
            'form' => $form,
            'user' => $user,
        ]);
    }

    #[Route('/mes-lieux', name: 'lieux')]
    public function mesLieux(): Response
    {
        return $this->render('profil/mes_lieux.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
}