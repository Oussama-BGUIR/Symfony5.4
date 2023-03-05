<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlatRepository;
use App\Repository\MenuRepository;


class StatistiquesController extends AbstractController
{
    #[Route('/statistiques', name: 'app_statistiques')]
    public function index(PlatRepository $platRepository, MenuRepository $menuRepository): Response
    {
        $plats = $platRepository->findAll();
        $platprix = [];
   
       foreach($plats as $plat){
          $platprix[] = $plat->getPrix();
    
       }

       $menus = $menuRepository->findAll();
      $menucalorie = [];
  
      foreach($menus as $menu){
          $menucalorie[] = $menu->getCalorie();
   
      }
       

        return $this->render('plat/statistiques.html.twig', [
            'platprix' => json_encode($platprix),
            'menucalorie' => json_encode($menucalorie),        ]);
    }
}
