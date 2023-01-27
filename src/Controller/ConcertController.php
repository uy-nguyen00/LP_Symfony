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

        return $this->render('concert/list.html.twig', ['concerts' => $concerts]);
    }
}