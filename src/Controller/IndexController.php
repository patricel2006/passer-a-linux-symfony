<?php

namespace App\Controller;

use App\Entity\Prestation;
use App\Form\RechercheRdvType;
use App\Services\RechercheRdv;
use App\Repository\CategoryRepository;
use App\Repository\PrestationRepository;
use App\Repository\RendezVousRepository;
use App\Repository\TarifsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(PrestationRepository $prestationRepository, CategoryRepository $categoryRepository, TarifsRepository $tarifsRepository): Response
    {
        return $this->render('index/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'prestations' => $prestationRepository->findAll(),
            'tarifs' => $tarifsRepository->findAll(),
        ]);
    }

    #[Route('/prestation-detail/{id}', name: 'user_prestation_show', methods: ['GET', 'POST'])]
    public function show(RendezVousRepository $rendezVousRepository,  Request $request, Prestation $prestation): Response
    {
        $rechercheRdv = new RechercheRdv();
        $form = $this->createForm(RechercheRdvType::class, $rechercheRdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date_rdv = $form->get('date_rdv')->getData();
            $rdvs = $rendezVousRepository->findBy([
                'date_rdv' => $date_rdv,
            ]);
            return $this->render('index/rdv.html.twig', [
                'prestation' => $prestation,
                'rdvs' => $rdvs,
            ]);
        }

        return $this->render('index/show.html.twig', [
            'prestation' => $prestation,
            'form' => $form->createView(),
        ]);
    }
}
