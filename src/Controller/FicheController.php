<?php

namespace App\Controller;

use App\Entity\Fiche;
use App\Form\FicheType;
use App\Repository\FicheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/fiche')]
class FicheController extends AbstractController
{
    #[Route('/', name: 'app_fiche_index', methods: ['GET'])]
    public function index(FicheRepository $ficheRepository,Request $request,PaginatorInterface $paginator): Response
    {
        {
            $Fiche = $ficheRepository->findAll();
            $Fiche  = $paginator->paginate(
                $Fiche , /* query NOT result */
                $request->query->getInt('page', 1),
                3
            );
            return $this->render('fiche/index.html.twig', [
               'Fiche'=>$Fiche
            ]);
        }  
    }



    #[Route('/new', name: 'app_fiche_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FicheRepository $ficheRepository): Response
    {
        $fiche = new Fiche();
        $form = $this->createForm(FicheType::class, $fiche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if the date is greater than current date
            $this->addFlash('success', 'Fiche ajoutée');
            
            $ficheRepository->add($fiche, true);

    
            return $this->redirectToRoute('app_fiche_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fiche/new.html.twig', [
            'fiche' => $fiche,
            'form' => $form,
        ]);
    }



    #[Route("/AllFiche", name: "list")]
    public function getFiches(FicheRepository $repo, SerializerInterface $serializer)
    {
        $fiches = $repo->findAll();
        $json = $serializer->serialize($fiches, 'json', ['groups' => "fiche"]);
        $json1=json_encode($fiches);
        dd($json1);
        //* Nous renvoyons une réponse Http qui prend en paramètre un tableau en format JSON

        die;
        return $this->render('fiche/index.html.twig', [
            'fiches' => $repo->findAll(),
         ]);
    }





    #[Route("addFiche", name: "addFiche")]
    public function addFiche(Request $req,   NormalizerInterface $Normalizer)
    {

        $em = $this->getDoctrine()->getManager();
        $fiche = new fiche();
        $fiche->setNom($req->get('nom'));
        $fiche->setPrenom($req->get('prenom'));
        $em->persist($fiche);
        $em->flush();

        $jsonContent = $Normalizer->normalize($fiche, 'json', ['groups' => 'fiches']);
        return new Response(json_encode($jsonContent));
    }

    #[Route('/{id}', name: 'app_fiche_show', methods: ['GET'])]
    public function show(Fiche $fiche): Response
    {
        return $this->render('fiche/show.html.twig', [
            'fiche' => $fiche,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_fiche_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fiche $fiche, FicheRepository $ficheRepository): Response
    {
        $form = $this->createForm(FicheType::class, $fiche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Fiche modifiée');
            $ficheRepository->add($fiche, true);

            return $this->redirectToRoute('app_fiche_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fiche/edit.html.twig', [
            'fiche' => $fiche,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fiche_delete', methods: ['POST'])]
    public function delete(Request $request, Fiche $fiche, FicheRepository $ficheRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fiche->getId(), $request->request->get('_token'))) {
            $ficheRepository->remove($fiche, true);
            $this->addFlash('success', 'Fiche supprimée');
        }

        return $this->redirectToRoute('app_fiche_index', [], Response::HTTP_SEE_OTHER);
    }
}
