<?php

namespace App\Controller;

use App\Entity\Concert;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConcertController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('/concerts', name: 'concerts_list', methods: ['GET'])]
    public function list(ManagerRegistry $doctrine): Response
    {
        $concerts = $doctrine->getRepository(Concert::class)->findAll();

        if (!$concerts) {
            throw $this->createNotFoundException('There is no concert at the moment');
        }

        return $this->render('concerts/list.html.twig', ['concerts' => $concerts]);
    }

    #[Route('/concerts/{id}', name: 'concert_show', methods: ['GET', 'HEAD'])]
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $concert = $doctrine->getRepository(Concert::class)->find($id);

        if (!$concert) {
            throw $this->createNotFoundException("There is no concert with the id $id");
        }

        return $this->render('concerts/show.html.twig', ['concert' => $concert]);
    }
}