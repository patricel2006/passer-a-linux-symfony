<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Repository\RendezVousRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route('/user')]
class PriseRendezVousController extends AbstractController
{
    #[Route('/prise/rendez-vous', name: 'app_prise_rendez_vous')]
    public function index(RendezVousRepository $rendezVousRepository): Response
    {
        return $this->render('prise_rendez_vous/index.html.twig', [
            'rendez_vous' => $rendezVousRepository->findAll(),
        ]);
    }

    #[Route('/prise/{id}', name: 'app_show_rendez_vous')]
    public function show(RendezVous $rendezVou): Response
    {
        return $this->render('prise_rendez_vous/show.html.twig', [
            'rendez_vou' => $rendezVou,
        ]);
    }

    #[Route('/prise/reservation/{id}', name: 'app_reservation_rendez_vous', methods: 'GET')]
    public function reserver(RendezVous $rendezVous, RendezVousRepository $rendezVousRepository): Response
    {
        if (!$rendezVous) {
            throw $this->createNotFoundException("ce rendez-vous n'existe pas.");
        }
        $rendezVous->setUser($this->getUser()); // lier un user à ce rendez-vous
        $rendezVous->setStatus("réservé"); // modifier le status du rendez-vous
        $rendezVousRepository->save($rendezVous, true); // modifier le status du rendez-vous en bdd

        $this->addFlash('success', "Le rendez-vous " . $rendezVous->getName() . " a été réservé.");

        return $this->redirectToRoute('app_prise_rendez_vous');
    }
}
