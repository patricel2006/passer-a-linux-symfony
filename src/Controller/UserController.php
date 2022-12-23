<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(RendezVousRepository $rendezVous): Response
    {
        $rdvUser = $rendezVous->findBy(['user' => $this->getUser()]);

        return $this->render('user/index.html.twig', [
            'rdvUsers' => $rdvUser
        ]);
    }
}
