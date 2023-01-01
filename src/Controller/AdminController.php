<?php

namespace App\Controller;

use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(RendezVousRepository $rendezVousRepository): Response
    {
        $rdvUsersReserve = $rendezVousRepository->findBy(['status' => 'réservé']);
        $rdvUsersValide = $rendezVousRepository->findBy(['status' => 'validé']);

        return $this->render('admin/index.html.twig', [
            'rdvUsersReserve' => $rdvUsersReserve,
            'rdvUsersValide' => $rdvUsersValide
        ]);
    }
}
