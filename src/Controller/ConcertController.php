<?php

namespace App\Controller;

use App\Entity\Concert;
use App\Form\ConcertType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConcertController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('/concerts', name: 'concert_list', methods: ['GET'])]
    public function list(ManagerRegistry $doctrine): Response
    {
        // Exclude the concert with status "canceled"
        $concerts = $doctrine->getRepository(Concert::class)->findBy(['status' => null]);

        if (!$concerts) {
            throw $this->createNotFoundException('There is no concert at the moment');
        }

        return $this->render('concerts/list.html.twig', ['concerts' => $concerts]);
    }

    #[Route('/concert/{id}', name: 'concert_show', requirements: ['id' => '\d+'], methods: ['GET', 'HEAD'])]
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $concert = $doctrine->getRepository(Concert::class)->find($id);

        if (!$concert) {
            throw $this->createNotFoundException("There is no concert with the id $id");
        }

        return $this->render('concerts/show.html.twig', ['concert' => $concert]);
    }

    #[Route('/concert/create', name: 'concert_create')]
    public function create(ManagerRegistry $doctrine, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        $concert = new Concert();
        return $this->handleForm($concert, $request, $doctrine);
    }

    /**
     * Instead of deleting the concert, we set its status to "canceled" to avoid relational problems with
     * App\Entity\Reservation.
     * @param ManagerRegistry $doctrine
     * @param int $id
     * @return Response
     */
    #[Route('concert/delete/{id}', name: 'concert_delete')]
    public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        /** @var Concert $concert */
        $concert = $doctrine->getRepository(Concert::class)->find($id);
        $concert->setStatus('canceled');
        $entityManager = $doctrine->getManager();
        $entityManager->persist($concert);
        $entityManager->flush();

        return $this->redirectToRoute('concert_list');
    }

    #[Route('concert/update/{id}', name: 'concert_update')]
    public function update(ManagerRegistry $doctrine, int $id, Request $request): RedirectResponse|Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        /** @var Concert $concert */
        $concert = $doctrine->getRepository(Concert::class)->find($id);
        return $this->handleForm($concert, $request, $doctrine);
    }

    /**
     * @param Concert $concert
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return RedirectResponse|Response
     */
    private function handleForm(Concert $concert, Request $request, ManagerRegistry $doctrine): Response|RedirectResponse
    {
        $form = $this->createForm(ConcertType::class, $concert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $concert = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($concert);
            $entityManager->flush();
            return $this->redirectToRoute('concert_list');
        }

        return $this->render('concerts/new.html.twig', ['form' => $form]);
    }
}