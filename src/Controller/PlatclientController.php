<?php

namespace App\Controller;
use App\Repository\PlatRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlatclientController extends AbstractController
{
    #[Route('/platclient', name: 'app_platclient' , methods: ['GET'] )]
    public function index(PlatRepository $platRepository): Response
    {
        return $this->render('platclient/platclient.html.twig', [
            'plats' => $platRepository->findAll(),
        ]);
    }



  



}
