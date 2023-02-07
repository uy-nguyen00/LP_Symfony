<?php

namespace App\Controller;

use App\Entity\Band;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('/', name: 'home_index', methods: ['GET'])]
    public function index(ManagerRegistry $doctrine): Response
    {
        return $this->render('home/index.html.twig');
    }
}