<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Plat;
use App\Entity\Menu;


class PlatsOfMenuController extends AbstractController
{
    #[Route('/plats/of/menu/{id}', name: 'app_plats_of_menu')]
    public function platOfMenu(Menu $menu)
    {

        $plats = $this->getDoctrine()
        ->getRepository(Plat::class)
        ->findBy(['menu' => $menu]);
        
        return $this->render('plats_of_menu/platsofmenu.html.twig', [

            'menu' => $menu,
            'plats' => $plats,
            
        ]);
    }



}
