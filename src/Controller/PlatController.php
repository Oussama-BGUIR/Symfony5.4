<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Form\Plat1Type;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/plat')]
class PlatController extends AbstractController
{
    #[Route('/', name: 'app_plat_index', methods: ['GET'])]
    public function index(PlatRepository $platRepository): Response
    {
        return $this->render('plat/plat.html.twig', [
            'plats' => $platRepository->findAll(),
        ]);
    }

    #[Route("/allplat", name: "listplat")]
    public function getPlats(PlatRepository $repo, SerializerInterface $serializer)
    {
        $plats = $repo->findAll();
        $json = $serializer->serialize($plats, 'json', ['groups' => "plat"]);
        $json1=json_encode($plats);
        dd($json1);
        //* Nous renvoyons une réponse Http qui prend en paramètre un tableau en format JSON

        die;
        return $this->render('plat/plat.html.twig', [
            'plats' => $repo->findAll(),
         ]);
    }

    #[Route('/new', name: 'app_plat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PlatRepository $platRepository, SluggerInterface $slugger): Response
    {
        $plat = new Plat();
        $form = $this->createForm(Plat1Type::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

              $photo = $form->get('photo')->getData();

              // this condition is needed because the 'brochure' field is not required
              // so the PDF file must be processed only when a file is uploaded
              if ($photo) {
                  $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                  // this is needed to safely include the file name as part of the URL
                  $safeFilename = $slugger->slug($originalFilename);
                  $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();
  
                  // Move the file to the directory where brochures are stored
                  try {
                      $photo->move(
                          $this->getParameter('plat_directory'),
                          $newFilename
                      );
                  } catch (FileException $e) {
                      // ... handle exception if something happens during file upload
                  }
  
                  // updates the 'brochureFilename' property to store the PDF file name
                  // instead of its contents
                  $plat->setImage($newFilename);
              }

            $platRepository->save($plat, true);

            return $this->redirectToRoute('app_plat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('plat/new.html.twig', [
            'plat' => $plat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_plat_show', methods: ['GET'])]
    public function show(Plat $plat): Response
    {
        return $this->render('plat/show.html.twig', [
            'plat' => $plat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_plat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Plat $plat, PlatRepository $platRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(Plat1Type::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $photo = $form->get('photo')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photo->move(
                        $this->getParameter('plat_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $plat->setImage($newFilename);
            }

            $platRepository->save($plat, true);

            return $this->redirectToRoute('app_plat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('plat/edit.html.twig', [
            'plat' => $plat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_plat_delete', methods: ['POST'])]
    public function delete(Request $request, Plat $plat, PlatRepository $platRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plat->getId(), $request->request->get('_token'))) {
            $platRepository->remove($plat, true);
        }

        return $this->redirectToRoute('app_plat_index', [], Response::HTTP_SEE_OTHER);
    }
}





// zedna 2 use  ou hedha  

// #[Route("/allplat", name: "listplat")]
// public function getPlats(PlatRepository $repo, SerializerInterface $serializer)
// {
//     $plats = $repo->findAll();
//     $json = $serializer->serialize($plats, 'json', ['groups' => "plat"]);
//     $json1=json_encode($plats);
//     dd($json1);
//     //* Nous renvoyons une réponse Http qui prend en paramètre un tableau en format JSON

//     die;
//     return $this->render('plat/plat.html.twig', [
//         'plats' => $repo->findAll(),
//      ]);
// } 