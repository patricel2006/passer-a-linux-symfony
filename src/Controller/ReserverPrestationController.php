<?php

namespace App\Controller;

use App\Entity\Prestation;
use App\Repository\PrestationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReserverPrestationController extends AbstractController
{
    #[Route('/lister/prestation', name: 'app_reserver_lister_prestation')]
    public function index(PrestationRepository $prestationRepository): Response
    {
        return $this->render('reserver_prestation/index.html.twig', [
            'prestations' => $prestationRepository->findAll(),
        ]);
    }

    #[Route('/prestation/{id}', name: 'app_reserver_show_prestation')]
    public function show(Prestation $prestation): Response
    {
        return $this->render('reserver_prestation/show.html.twig', [
            'prestation' => $prestation,
        ]);
    }

}
