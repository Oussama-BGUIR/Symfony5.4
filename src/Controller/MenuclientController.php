<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuclientController extends AbstractController
{
    #[Route('/menuclient', name: 'app_menuclient')]
    public function index(): Response
    {
        return $this->render('menuclient/menuclient.html.twig', [
            'controller_name' => 'MenuclientController',
        ]);
    }
}
