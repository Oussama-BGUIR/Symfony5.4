<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class ProduitHomeController extends AbstractController
{
    #[Route('/produithome', name: 'app_produithome_home', methods: ['GET'])]
    public function index(CategorieRepository $categorieRepository, ProduitRepository $produitRepository,Request $request,PaginatorInterface $paginator): Response
    {
        $produits = $produitRepository->findAll();
        $produits   = $paginator->paginate(
            $produits  , 
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('produit/produithome.html.twig', [
           'produits'=>$produits
        ]);


        // return $this->render('produit/produithome.html.twig', [
            
        //     'categories' => $categorieRepository->findAll(),
            
        //     'produits' => $produitRepository->findAll(),
        // ]);
    }
}
