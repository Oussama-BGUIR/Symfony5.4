<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Repository\AbonnementRepository;
use App\Form\AbonnementFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Mime\Email;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;






#[Route('/abonnement')]
class AbonnementController extends AbstractController
{
    #[Route('/', name: 'app_abonnement_index', methods: ['GET'])]
    public function index(AbonnementRepository $abonnementRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $Abonnement = $abonnementRepository->findAll();
        $Abonnement   = $paginator->paginate(
            $Abonnement  , /* query NOT result */
            $request->query->getInt('page', 1),
           2
        );
        return $this->render('abonnement/index.html.twig', [
            'Abonnement'=>$Abonnement
         ]);
    } 

    #[Route('/exportexcel', name: 'exportexcel', methods: ['GET'])]
    public function exportProductsToExcelAction(AbonnementRepository $abonnementRepository): Response
    {

        // Récupérer la liste des produits depuis votre source de données
      // $abonnements = $this->getDoctrine()->getRepository(Abonnement::class)->findAll();
       $Abonnements = $abonnementRepository->findAll();
        // Créer un nouveau document Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Abonnements');

        // Écrire les en-têtes de colonnes
        $sheet->setCellValue('A1', 'nom');
        $sheet->setCellValue('B1', 'prenom');
        $sheet->setCellValue('C1', 'numero ');
        $sheet->setCellValue('D1', 'email ');
        $sheet->setCellValue('E1', 'type ');
        // Écrire les données des abonnements
        $row = 2;
        foreach ($Abonnements as $abonnement) {
            $sheet->setCellValue('A'.$row, $abonnement->getNom());
            $sheet->setCellValue('B'.$row, $abonnement->getPrenom());
            $sheet->setCellValue('C'.$row, $abonnement->getNumero());
            $sheet->setCellValue('D'.$row, $abonnement->getEmail());
            $sheet->setCellValue('E'.$row, $abonnement->getType());
            $row++;
        }

        // Créer une réponse HTTP pour le document Excel
        $response = new Response();
        // Écrire le document Excel dans la réponse HTTP
        $writer = new Xlsx($spreadsheet);
        $writer->save('listeAbonnements.xlsx');

       
        return  $response;
    }
 
    
    #[Route("/AllMenu", name: "list")]
    public function getAbonnements(AbonnementRepository $repo, SerializerInterface $serializer)
    {
        $abonnements = $repo->findAll();
        $json = $serializer->serialize($abonnements, 'json', ['groups' => "abonnement"]);
        $json1=json_encode($abonnements);
        dd($json1);
        //* Nous renvoyons une réponse Http qui prend en paramètre un tableau en format JSON

        die;
        return $this->render('abonnement/index.html.twig', [
            'abonnements' => $repo->findAll(),
         ]);
    }
  
    #[Route('/new', name: 'app_abonnement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AbonnementRepository $abonnementRepository): Response
    {
        $abonnement = new Abonnement();
        $form = $this->createForm(AbonnementFormType::class, $abonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $abonnementRepository->save($abonnement, true);
            $email = (new Email())
                ->from('gymelite95@gmail.com')
                ->to ('lina.fakhfakh@esprit.tn')
                ->subject('ELITE GYM')
                ->text('Ton abonnement a été enregistré');
                $transport = new GmailSmtpTransport('gymelite95@gmail.com','sevlblnxqgzlxwnn');
                $mailer=new Mailer($transport);
                $mailer->send($email);
            return $this->redirectToRoute('app_abonnement_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('abonnement/new.html.twig', [
            'abonnement' => $abonnement,
            'form' => $form,
        ]);
    }



    #[Route('/{id}', name: 'app_abonnement_show', methods: ['GET'])]
    public function show(Abonnement $abonnement): Response
    {
        return $this->render('abonnement/show.html.twig', [
            'abonnement' => $abonnement,
        ]);
    }

    

    #[Route('/{id}/edit', name: 'app_abonnement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Abonnement $abonnement, AbonnementRepository $abonnementRepository): Response
    {
        $form = $this->createForm(AbonnementFormType::class, $abonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $abonnementRepository->save($abonnement, true);

            return $this->redirectToRoute('app_abonnement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('abonnement/edit.html.twig', [
            'abonnement' => $abonnement,
            'form' => $form,
        ]);
    }

    


    #[Route('/{id}', name: 'app_abonnement_delete', methods: ['POST'])]
    public function delete(Request $request, Abonnement $abonnement, AbonnementRepository $abonnementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$abonnement->getId(), $request->request->get('_token'))) {
            $abonnementRepository->remove($abonnement, true);
        }

        return $this->redirectToRoute('app_abonnement_index', [], Response::HTTP_SEE_OTHER);
    }

}
