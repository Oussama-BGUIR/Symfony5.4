<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use App\Repository\PlatRepository;

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
            'plats' => $platRepository->findAll(),

        ]);
    }


}
