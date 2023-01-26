<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Entity\Prestation;
use App\Form\PrestationType;
use App\Services\ImageManager;
use App\Repository\CategoryRepository;
use App\Repository\PrestationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class PrestationController extends AbstractController
{
    #[Route('/prestation', name: 'app_prestation_index', methods: ['GET'])]
    public function index(PrestationRepository $prestationRepository): Response
    {
        return $this->render('prestation/index.html.twig', [
            'prestations' => $prestationRepository->findAll(),
        ]);
    }

    #[Route('/prestation/new', name: 'app_prestation_new', methods: ['GET', 'POST'])]
    public function new(CategoryRepository $categoryRepository, ImageManager $imageManager, Request $request, PrestationRepository $prestationRepository): Response
    {
        $prestation = new Prestation();
        $form = $this->createForm(PrestationType::class, $prestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageManager->loadImage($form, 'image', $prestation); // rajouter une image à la table

            $prestationRepository->save($prestation, true);

            return $this->redirectToRoute('app_prestation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prestation/new.html.twig', [
            'prestation' => $prestation,
            'form' => $form,
        ]);
    }

    #[Route('/prestation/{id}', name: 'app_prestation_show', methods: ['GET'])]
    public function show(Prestation $prestation): Response
    {
        return $this->render('prestation/show.html.twig', [
            'prestation' => $prestation,
        ]);
    }

    #[Route('/prestation/{id}/edit', name: 'app_prestation_edit', methods: ['GET', 'POST'])]
    public function edit(ImageManager $imageManager, Request $request, Prestation $prestation, PrestationRepository $prestationRepository): Response
    {
        $old_name_icon = $prestation->getImage();

        $form = $this->createForm(PrestationType::class, $prestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageManager->loadImage($form, 'image', $prestation, $old_name_icon); // rajouter une image à la table

            $prestationRepository->save($prestation, true);

            return $this->redirectToRoute('app_prestation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('prestation/edit.html.twig', [
            'prestation' => $prestation,
            'form' => $form,
        ]);
    }

    #[Route('/prestation/{id}', name: 'app_prestation_delete', methods: ['POST'])]
    public function delete(Request $request, Prestation $prestation, PrestationRepository $prestationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $prestation->getId(), $request->request->get('_token'))) {
            $prestationRepository->remove($prestation, true);
        }

        return $this->redirectToRoute('app_prestation_index', [], Response::HTTP_SEE_OTHER);
    }
}
