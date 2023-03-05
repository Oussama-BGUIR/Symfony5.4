<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursClientController extends AbstractController
{
    #[Route('/cours/client', name: 'app_cours_client')]
    public function index(): Response
    {
        return $this->render('cours_client/coursClient.html.twig', [
            'controller_name' => 'CoursClientController',
        ]);
    }
}
