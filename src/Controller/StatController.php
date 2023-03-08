<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OffreRepository;

class StatController extends AbstractController
{
    #[Route('/stat', name: 'app_stat')]
   public function stat(OffreRepository $offreRepository): Response
    {
        $offres = $offreRepository->findAll();
         $offrePoints = [];
        $offrePrix = [];
    
        foreach($offres as $offre){
           $offrePoints[] = $offre->getPoints();
            $offrePrix[] = $offre->getPrix();
     
        }
       return $this->render('offre/stats.html.twig', [
            'offrePoints' => json_encode($offrePoints),
            'offrePrix' => json_encode($offrePrix),
    
        ]);
      
    }
}
