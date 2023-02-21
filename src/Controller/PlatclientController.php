<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlatclientController extends AbstractController
{
    #[Route('/platclient', name: 'app_platclient')]
    public function index(): Response
    {
        return $this->render('platclient/platclient.html.twig', [
            'controller_name' => 'PlatclientController',
        ]);
    }
}
