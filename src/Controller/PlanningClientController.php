<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PlanningRepository;

class PlanningClientController extends AbstractController
{
    #[Route('/planning/client', name: 'app_planning_client')]
    public function index(PlanningRepository $planningRepository,  Request $request,PaginatorInterface $paginator): Response
    {
        $plannings = $planningRepository->findAll();
        $plannings   = $paginator->paginate(
            $plannings  , /* query NOT result */
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('planning_client/planningClient.html.twig', [
            'plannings' => $plannings
        ]);
    }
}
