<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RdvclientController extends AbstractController
{
    #[Route('/rdvclient', name: 'app_rdvclient')]
    public function index(): Response
    {
        return $this->render('rdvclient/rdvclient.html.twig', [
            'controller_name' => 'RdvclientController',
        ]);
    }
}
