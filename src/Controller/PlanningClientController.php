<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanningClientController extends AbstractController
{
    #[Route('/planning/client', name: 'app_planning_client')]
    public function index(): Response
    {
        return $this->render('planning_client/planningClient.html.twig', [
            'controller_name' => 'PlanningClientController',
        ]);
    }
}
