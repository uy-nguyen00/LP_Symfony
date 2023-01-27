<?php
namespace App\Controller;

use App\Entity\Band;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BandController extends AbstractController
{
    #[Route('/bands', name: 'bands_list', methods: ['GET'])]
    public function list(ManagerRegistry $doctrine): Response
    {
        $bands = $doctrine->getRepository(Band::class)->findAll();

        if (!$bands) {
            throw $this->createNotFoundException('There is no band at the moment');
        }

        return $this->render('band/list.html.twig', ['bands' => $bands]);
    }
}