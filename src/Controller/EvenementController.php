<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/evenements', name: 'app_evenement_')]
class EvenementController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(
        Request $request,
        EvenementRepository $evenementRepo,
        PaginatorInterface $paginator
    ): Response {
        $recherche     = $request->query->get('q');
        $filtreGratuit = $request->query->get('gratuit');

        $query = $evenementRepo->findByFiltresQuery($recherche, $filtreGratuit);

        $evenements = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            6
        );
        
        return $this->render('evenement/index.html.twig', [
            'evenements'    => $evenements,
            'recherche'     => $recherche,
            'filtreGratuit' => $filtreGratuit,
        ]);
    }

    #[Route('/nouveau', name: 'new')]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $evenement = new Evenement();
        $form      = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenement->setCreatedAt(new \DateTimeImmutable());
            $evenement->setUser($this->getUser());

            $em->persist($evenement);
            $em->flush();

            $this->addFlash('success', '✅ Votre événement a été publié !');
            return $this->redirectToRoute('app_evenement_index');
        }

        return $this->render('evenement/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }
}
