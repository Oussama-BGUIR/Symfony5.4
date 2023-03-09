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
        $platNom = [];
   
       foreach($plats as $plat){
          $platNom[] = $plat->getNom();
    
       }

       $menus = $menuRepository->findAll();
      $menuId = [];
  
      foreach($menus as $menu){
          $menuId[] = $menu->getId();
   
      }
       

        return $this->render('plat/statistiques.html.twig', [
            'platNom' => json_encode($platNom),
            'menuId' => json_encode($menuId),        ]);
    }
}
