<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CoursRepository;



class CoursClientController extends AbstractController
{
    #[Route('/cours/client', name: 'app_cours_client')]
    public function index(CoursRepository $coursRepository,  Request $request,PaginatorInterface $paginator): Response
    {
        $cours = $coursRepository->findAll();
        $cours   = $paginator->paginate(
            $cours  , /* query NOT result */
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('cours_client/coursClient.html.twig', [
            'cours' => $cours
        ]);
    }

}
