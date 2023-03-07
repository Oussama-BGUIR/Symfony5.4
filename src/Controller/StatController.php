<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlanningRepository;
use App\Repository\CoursRepository;


class StatController extends AbstractController
{
    #[Route('/stat', name: 'app_stat')]

    public function index(CoursRepository $coursRepository, PlanningRepository $planningRepository): Response
    {
        $cour = $coursRepository->findAll();
        $coursnom = [];
   
       foreach($cour as $cours){
          $coursnom[] = $cours->getNom();
    
       }

       $plannings = $planningRepository->findAll();
      $planningId = [];
  
      foreach($plannings as $planning){
          $planningId[] = $planning->getId();
   
      }
       

        return $this->render('cours/stat.html.twig', [
            'coursnom' => json_encode($coursnom),
            'planningId' => json_encode($planningId),        ]);
    }
    // public function index(): Response
    // {
    //     return $this->render('stat/index.html.twig', [
    //         'controller_name' => 'StatController',
    //     ]);
    // }
}
