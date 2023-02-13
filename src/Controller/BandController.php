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

        return $this->render('bands/list.html.twig', ['bands' => $bands]);
    }

    #[Route('/band/{id}', name: 'band_show', methods: ['GET', 'HEAD'])]
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $band = $doctrine->getRepository(Band::class)->find($id);

        if (!$band) {
            throw $this->createNotFoundException("There is no band with the id $id");
        }

        return $this->render('bands/show.html.twig', ['band' => $band]);
    }
}