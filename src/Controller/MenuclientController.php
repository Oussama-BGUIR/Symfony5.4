<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use App\Repository\PlatRepository;
use App\Entity\Plat;
use App\Entity\Menu;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuclientController extends AbstractController
{




    #[Route('/menuclient', name: 'app_menuclient', methods: ['GET'])]
    public function index(MenuRepository $menuRepository, PlatRepository $platRepository): Response
    {


        return $this->render('menuclient/menuclient.html.twig', [
            'menus' => $menuRepository->findAll(),
            // 'plats' => $platRepository->findBy(Id),
          // 'plats' => $platRepository->findOneBy(),
            'plats' => $platRepository->findAll(),       
        ]);
    }

 
//     #[Route('/aaa/{id}', name: 'app_aaa', methods: ['GET'])]
//     public function aa(id $id): Response
//     {
//         dd($plats).die();
//         $plat = $this->getDoctrine()
//         ->getRepository(Plat::class)
//         ->findBy(['Menu' => $menu]);
// dd($plat).die();
//     return $this->render('plats_of_menu/platsofmenu.html.twig', [
//         'plats' => $plats,
//         'Menu' => $menu,
//     ]);
//     }

    // #[Route('/menuclient/{id}', name: 'app_platsofmenu')]

    // public function platsparmenu(id $idMenu $menu)
    // {
        // dd(id).die()
        // plat=find(id)
    //     $plats = $this->getDoctrine()
    //     ->getRepository(Plat::class)
    //     ->findBy(['Menu' => $menu]);
    
    //     return $this->render('plats_of_menu/platsofmenu.html.twig', [
    //        'plats'=>$plats,
    //        'Menus' => $menu,
    
    
    //     ]);

    //     // return $this->render('plats_of_menu/platsofmenu.html.twig', [
    //     //     'Menu' => $menu,
    //     //     'plats' => $plats,
    //     // ]);
    // }

}
