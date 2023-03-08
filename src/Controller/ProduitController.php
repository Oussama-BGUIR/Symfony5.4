<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface; /* taswira */
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    #[Route('/panier', name: 'affichage_panier_front')]
    public function indexFront(SessionInterface $session, ProduitRepository $produitRepository)
    {
        $panier = $session->get("panier", []);

        if (!is_array($panier)) {
            $dataPanier = [];
            $total = 0;
        } else {
            // On "fabrique" les données
            $dataPanier = [];
            $total = 0;

            foreach ($panier as $id => $quantite) {
                $produit = $produitRepository->find($id);
                $dataPanier[] = [
                    "produit" => $produit,
                    "quantite" => $quantite
                ];
                $total += $produit->getPrix() * $quantite;
            }
        }

        return $this->render('produit/panier.html.twig', compact("dataPanier", "total"));
    }


    /**
     * @Route ("/add/{id}",name="add")
     * @return void
     */
    public function add(Produit $produit,SessionInterface $session)
    {
        //on récupere le panier actuel
        $panier = $session->get("panier", []);
        $id=$produit->getId();
        if(!empty ($panier[$id])) {
            $panier[$id]++;
        }else {
            $panier[$id] = 1;
        }

        dump($panier);
        dump($session->get('panier'));

        // on sauvgarde dans la session
        $session->set("panier",$panier);
        return $this->redirectToRoute("affichage_panier_front");
    }
    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove(Produit $produit, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $produit->getId();

        if(!empty($panier[$id])) {
            if ($panier[$id] > 1) {
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        }
        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("affichage_panier_front");
    }
    /**
     * @Route("/deleteCommande/{id}", name="deleteCommande")
     */
    public function deleteCommande (Produit $produit, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $produit->getId();

        if(!empty($panier[$id])) {
                unset($panier[$id]);
        }
        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("affichage_panier_front");
    }







    #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProduitRepository $produitRepository,SluggerInterface $slugger/*tasiwra*/): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    dd("erruer " +  $e->toString());
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $produit->setImage($newFilename);
            }

            $produitRepository->save($produit, true);

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }
        

        return $this->renderForm('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }
    
    #[Route("/Allproduits", name: "list")]
    public function getProduits(ProduitRepository $repo, SerializerInterface $serializer)
    {
        $produits = $repo->findAll();
        $json = $serializer->serialize($produits, 'json', ['groups' => "produit"]);
        $json1=json_encode($produits);
        dd($json1);
    
        die;
        return $this->render('produit/index.html.twig', [
            'produits' => $repo->findAll(),
         ]);
    }

    #[Route('/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produitRepository->save($produit, true);

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $produitRepository->remove($produit, true);
        }

        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }

    

    

}
