<?php

namespace App\Controller;
use App\Repository\PlatRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Plat;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

use Dompdf\Dompdf;
use Dompdf\Options;

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


    }







    #[Route('/panier', name: 'affichage_panier_front')]
    public function indexFront(SessionInterface $session, PlatRepository $platRepository)
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
                $plat = $platRepository->find($id);
                $dataPanier[] = [
                    "plat" => $plat,
                    "quantite" => $quantite
                ];
                $total += $plat->getPrix() * $quantite;
            }
        }

        return $this->render('panier/panier.html.twig', compact("dataPanier", "total"));
    }


    

    #[Route('panier/pdf', name: 'pdf' , methods: ['GET'] )]

    public function listp(EntityManagerInterface $entityManager , Request $request, SessionInterface $session, PlatRepository $platRepository) : Response
    {

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $panier = $session->get("panier", []);

        if (!is_array($panier)) {
            $dataPanier = [];
            $total = 0;
        } else {
            // On "fabrique" les données
            $dataPanier = [];
            $total = 0;

            foreach ($panier as $id => $quantite) {
                $plat = $platRepository->find($id);
                $dataPanier[] = [
                    "plat" => $plat,
                    "quantite" => $quantite
                ];
                $total += $plat->getPrix() * $quantite;
            }
        }

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('panier/pdf.html.twig', compact("dataPanier", "total"));

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser (force download)
        $dompdf->stream("MyList.pdf", [
            "Attachment" => false
        ]);

        return new Response('success');

    }


    /**
     * @Route("/trie_nom", name="trie_nom")
     */
    public function orderByNom(EntityManagerInterface $entityManager,UserRepository $repository,Request $request)
    {


        $allNom = $repository->orderByNom();


        return $this->render('user/index.html.twig', [
            'users' => $appointments,

        ]);
    }




  
    #[Route('/add/{id}', name: 'add')]
  
    public function add(Plat $plat,SessionInterface $session)
    {
        //on récupere le panier actuel
        $panier = $session->get("panier", []);
        $id=$plat->getId();
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



    #[Route('/remove/{id}', name: 'remove')]


    public function remove(Plat $plat, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $plat->getId();

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

    #[Route('/deleteCommande/{id}', name: 'deleteCommande')]

 
    public function deleteCommande (Plat $plat, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $plat->getId();

        if(!empty($panier[$id])) {
                unset($panier[$id]);
        }
        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("affichage_panier_front");
    }


}

