<?php

namespace App\Controller;

use App\Entity\Tarifs;
use App\Form\TarifsType;
use App\Repository\TarifsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tarifs')]
class TarifsController extends AbstractController
{
    #[Route('/', name: 'app_tarifs_index', methods: ['GET'])]
    public function index(TarifsRepository $tarifsRepository): Response
    {
        return $this->render('tarifs/index.html.twig', [
            'tarifs' => $tarifsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tarifs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TarifsRepository $tarifsRepository): Response
    {
        $tarif = new Tarifs();
        $form = $this->createForm(TarifsType::class, $tarif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tarifsRepository->save($tarif, true);

            return $this->redirectToRoute('app_tarifs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tarifs/new.html.twig', [
            'tarif' => $tarif,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tarifs_show', methods: ['GET'])]
    public function show(Tarifs $tarif): Response
    {
        return $this->render('tarifs/show.html.twig', [
            'tarif' => $tarif,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tarifs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tarifs $tarif, TarifsRepository $tarifsRepository): Response
    {
        $form = $this->createForm(TarifsType::class, $tarif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tarifsRepository->save($tarif, true);

            return $this->redirectToRoute('app_tarifs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tarifs/edit.html.twig', [
            'tarif' => $tarif,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tarifs_delete', methods: ['POST'])]
    public function delete(Request $request, Tarifs $tarif, TarifsRepository $tarifsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tarif->getId(), $request->request->get('_token'))) {
            $tarifsRepository->remove($tarif, true);
        }

        return $this->redirectToRoute('app_tarifs_index', [], Response::HTTP_SEE_OTHER);
    }
}
