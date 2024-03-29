<?php

namespace App\Controller;

use App\Entity\Band;
use App\Form\BandType;
use App\Repository\BandRepository;
use App\Repository\ConcertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/band')]
class BandController extends StandardController
{
    #[Route('/', name: 'app_band_index', methods: ['GET'])]
    public function index(BandRepository $bandRepository): Response
    {
        return $this->render('band/index.html.twig', [
            'bands' => $bandRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_band_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BandRepository $bandRepository): Response
    {
        $band = new Band();
        $form = $this->createForm(BandType::class, $band);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($pictureName = $this->savePictureFile($form)) {
                $band->setPicture($pictureName);
            }
            $bandRepository->save($band, true);

            return $this->redirectToRoute('app_band_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('band/new.html.twig', [
            'band' => $band,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_band_show', methods: ['GET'])]
    public function show(Band $band, ConcertRepository $concertRepository): Response
    {
        $concerts = $concertRepository->findByBand($band->getId());
        return $this->render('band/show.html.twig', [
            'band' => $band,
            'concerts' => $concerts
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_band_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Band $band, BandRepository $bandRepository): Response
    {
        $form = $this->createForm(BandType::class, $band);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($pictureName = $this->savePictureFile($form)) {
                $band->setPicture($pictureName);
            }
            $bandRepository->save($band, true);

            return $this->redirectToRoute('app_band_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('band/edit.html.twig', [
            'band' => $band,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_band_delete', methods: ['POST'])]
    public function delete(Request $request, Band $band, BandRepository $bandRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$band->getId(), $request->request->get('_token'))) {
            $bandRepository->remove($band, true);
        }

        return $this->redirectToRoute('app_band_index', [], Response::HTTP_SEE_OTHER);
    }
}
