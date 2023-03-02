<?php

namespace App\Controller;
use App\Repository\PlatRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class PlatclientController extends AbstractController
{
    #[Route('/platclient', name: 'app_platclient' , methods: ['GET'] )]
    public function index(PlatRepository $platRepository, Request $request,PaginatorInterface $paginator): Response
    {

        $plats = $platRepository->findAll();
        $plats   = $paginator->paginate(
            $plats  , /* query NOT result */
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('platclient/platclient.html.twig', [
           'plats'=>$plats
        ]);


        // return $this->render('platclient/platclient.html.twig', [
        //     'plats' => $platRepository->findAll(), 'plats'=>$plats 
        // ]);
    }




    // public function platsParMenu(Menu $categorie)
    // {
    //     $plats = $this->getDoctrine()
    //         ->getRepository(Plat::class)
    //         ->findBy(['Menu' => $menu]);

    //     return $this->render('platclient/platclient.html.twig', [
    //         'Menu' => $menu,
    //         'plats' => $plats,
    //     ]);
    // }



  



}
